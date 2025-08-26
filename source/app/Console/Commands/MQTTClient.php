<?php

namespace App\Console\Commands;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\RoomUser;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Workerman\Mqtt\Client;
use Workerman\Worker;

class MQTTClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chat server using workerman/mqtt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $mqttHost = env('MQTT_HOST');
            $mqttPort = env('MQTT_PORT');
            $mqttUser = env('MQTT_USERNAME');
            $mqttPass = env('MQTT_PASSWORD');
            $options = [
                'username' => $mqttUser,
                'password' => $mqttPass,
                'clean_session' => false,
                'client_id' => 'chat_server_' . uniqid()
            ];
            if (env('APP_ENV') == 'prod') {
                $options['ssl'] = [
                    'local_cert' => env('LOCAL_CERT'),
                    'local_pk' => env('LOCAL_PK'),
                    'verify_peer' => false,
                    'allow_self_signed' => true,
                ];
                $mqttUrl = "mqtts://{$mqttHost}:{$mqttPort}";
            } else {
                $mqttPort = '1883';
                $options['debug'] = true;
                $mqttUrl = "mqtt://{$mqttHost}:{$mqttPort}";
            }

            $worker = new Worker();
            $worker->onWorkerStart = function () use ($mqttHost, $mqttPort, $mqttUrl, $options) {
                echo "Connected to MQTT broker\n$mqttUrl";
                $mqtt = new Client($mqttUrl, $options);

                $mqtt->onConnect = function ($mqtt) {
                    echo "Connected to MQTT broker\n";
                    $mqtt->subscribe('chat/+');
                    $mqtt->subscribe('chat/presence/+');

                };

                $mqtt->onMessage = function ($topic, $content) use ($mqtt) {
                    echo "chat event ==> {$topic} =>>$content\n";
                    $chatService = new ChatService();

                    $isBase64 = base64_encode(base64_decode($content, true)) === $content;
                    if ($isBase64) {
                        $content = base64_decode($content, true);
                    }
                    $payload = json_decode($content, true);


                    $topic = explode('/', $topic);
                    $command = $topic[1] ?? null;

                    if (isset($topic[1]) && $topic[1] == 'presence') {
                        $command = "presence";
                        $payload['user_id'] = $payload['user_id'] ?? $topic[2] ?? null;
                    }
                    switch ($command) {
                        case 'join-room':
                            $chatService->joinRoom($payload, $mqtt);
                            break;
                        case 'send-message':
                            $chatService->sendMessage($payload, $mqtt);
                            break;
                        case 'presence':
                            $chatService->presence($payload, $mqtt);
                            break;
                        case 'delete-message':
                            $chatService->deleteMessage($payload, $mqtt);
                            break;
                    }
                };

                $mqtt->connect();
            };

            Worker::runAll();
        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
            echo $e->getMessage() . $e->getLine() . "\n";
        }
    }
}
