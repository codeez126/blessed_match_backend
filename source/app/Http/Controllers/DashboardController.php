<?php

namespace App\Http\Controllers;

use App\Models\ContactEntery;
use App\Models\Faqs;
use App\Models\HeaderInfo;
use App\Models\Pages;
use App\Models\Permissions;
use App\Models\Social;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superAdminDashboard(){

        return view('admin.dashboard');
    }


    public function generalUserDashboard(){
        return view('user.UserDashboard');
    }
    public function headerInfo(){
        $headerData= HeaderInfo::query()->where('id', 1)->first();
        return view('admin.headerinfo', [
            'headerData'=> $headerData,
        ]);
    }

    public function headerInfoEdit(Request $request) {
        try {
            \DB::beginTransaction();

            $form_input_Data = array(
                'logo1alt' => $request['logo1alt'],
                'logo2alt' => $request['logo2alt'],
                'siteName' => $request['siteName'],
                'siteUrl' => $request['siteUrl'],
                'siteEmail' => $request['siteEmail'],
                'sitePhone' => $request['sitePhone'],
                'address' => $request['address'],
                'themecolor1' => $request['themecolor1'],
                'themecolor2' => $request['themecolor2'],
                'themecolor3' => $request['themecolor3'],
            );
            HeaderInfo::query()->whereId('1')->update($form_input_Data);

            if ($request->file('logo1')) {
                $front_image_file = $request->file('logo1');
                $front_image_file_path = 'assets/logo';
                $front_image_file_name = $front_image_file->getClientOriginalName();
                $front_image_file->move($front_image_file_path, $front_image_file_name);
                HeaderInfo::whereId('1')->update([
                    'logo1' => $front_image_file_path . '/' . $front_image_file_name,
                ]);
            }

            if ($request->file('logo2')) {
                $front_image_file = $request->file('logo2');
                $front_image_file_path = 'assets/logo';
                $front_image_file_name = $front_image_file->getClientOriginalName();
                $front_image_file->move($front_image_file_path, $front_image_file_name);
                HeaderInfo::whereId('1')->update([
                    'logo2' => $front_image_file_path . '/' . $front_image_file_name,
                ]);
            }

            \DB::commit();

            return redirect()->back()->with('success', 'Header Updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

//pages
  public function pagesadd(){
        return view('admin.pages.add');
  }
    public function pagesstore(Request $request)
    {
        try {
            \DB::beginTransaction();

            // Prepare page data
            $form_input_Data = array(
                'page_name' => $request['page_name'],
                'page_url' => $request['page_url'],
                'page_heading' => $request['page_heading'],
                'page_content' => $request['page_content'],
                'page_content2' => $request['page_content2'],
                'page_banner_alt' => $request['page_banner_alt'],
                'status' => $request->has('status') ? '1' : '0',
                'is_index' => $request->has('is_index') ? '1' : '0',
                'not_domain_specific' => $request->has('not_domain_specific') ? '1' : '0',
                'text_direction_right' => $request->has('text_direction_right') ? '1' : '0',
                'lang_he' => $request->has('lang_he') ? '1' : '0',
                'meta_title' => $request['meta_title'],
                'meta_keywords' => $request['meta_keywords'],
                'meta_description' => $request['meta_description'],
            );

            // Create the page
            $page = Pages::create($form_input_Data);

            // Handle page banner upload
            if ($request->file('page_banner')) {
                $front_image_file = $request->file('page_banner');
                $front_image_file_path = 'assets/pages';
                $front_image_file_name = time() . '_' . $front_image_file->getClientOriginalName();
                $front_image_file->move($front_image_file_path, $front_image_file_name);

                $page->update([
                    'page_banner' => $front_image_file_path . '/' . $front_image_file_name,
                ]);
            }

            // Handle FAQ data
            $faqs = $request->input('faq_question', []);
            foreach ($faqs as $faq) {
                Faqs::create([
                    'refrence_id' => $page->id,
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'type' => 'page',
                ]);
            }

            \DB::commit();

            return redirect()->route('pages')->with('success', 'Page created successfully');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function pages() {
        $pages = Pages::query()->get();
        return view('admin.pages.pages', [
            'pages' => $pages,
        ]);
    }

    public function fetchPageData(Request $request) {
        $pageId = $request->input('id');

        if (!$pageId) {
            return response()->json(['error' => 'Page ID is required'], 400);
        }

        // Fetch page data
        $page = Pages::find($pageId);

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        // Fetch related FAQs
        $faqs = Faqs::where('type', 'page')->where('refrence_id', $pageId)->get();

        return response()->json([
            'page' => $page,
            'faqs' => $faqs
        ]);
    }


    public function pagesEdit(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $form_input_Data = [
                'page_heading' => $request['page_heading'],
                'page_content' => $request['page_content'],
                'page_content2' => $request['page_content2'],
                'page_banner_alt' => $request['page_banner_alt'],
                'status' => $request->has('status') ? '1' : '0',
                'is_index' => $request->has('is_index') ? '1' : '0',
                'text_direction_right' => $request->has('text_direction_right') ? '1' : '0',
                'lang_he' => $request->has('lang_he') ? '1' : '0',
                'not_domain_specific' => $request->has('not_domain_specific') ? '1' : '0',
                'meta_title' => $request['meta_title'],
                'meta_keywords' => $request['meta_keywords'],
                'meta_description' => $request['meta_description'],
            ];

            // Fetch the page instance
            $page = Pages::find($id);

            if (!$page) {
                throw new \Exception('Page not found');
            }

            // Update the page with the new data
            $page->update($form_input_Data);

            if ($request->file('page_banner')) {
                $front_image_file = $request->file('page_banner');
                $front_image_file_path = 'assets/pages';
                $front_image_file_name = $front_image_file->getClientOriginalName();
                $front_image_file->move($front_image_file_path, $front_image_file_name);
                $page->update([
                    'page_banner' => $front_image_file_path . '/' . $front_image_file_name,
                ]);
            }

            // Handle FAQ updates
            Faqs::where('refrence_id', $page->id)->where('type', 'page')->delete();
            if ($request->has('faq_question')) {
                // First, delete existing FAQs for the page

                // Then, create new FAQs
                foreach ($request->faq_question as $index => $faq) {
                    if (isset($faq['question']) && isset($faq['answer'])) {
                        Faqs::create([
                            'refrence_id' => $page->id,
                            'question' => $faq['question'],
                            'answer' => $faq['answer'],
                            'type' => 'page',
                        ]);
                    }
                }
            }

            \DB::commit();

            return redirect()->route('pages')->with('success', 'Page updated successfully');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


//socail media
   public function soacialmedia(){
        $social= Social::query()->where('id', 1)->first();
        return view('admin.socailmedia',[
            'social'=>$social,
        ]);
   }

    public function soacialEdit(Request $request) {
        try {
            \DB::beginTransaction();

            $form_input_Data = array(
                'facebook' => $request['facebook'],
                'twitter' => $request['twitter'],
                'googleplus' => $request['googleplus'],
                'linkedin' => $request['linkedin'],
                'youtube' => $request['youtube'],
                'pinterest' => $request['pinterest'],
                'instagram' => $request['instagram'],
            );
            Social::query()->update($form_input_Data);
            \DB::commit();

            return redirect()->route('soacialmedia')->with('success', 'Social Media updated successfully');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


//    contact enteries
   public function contactEnteries(){
     $contacts= ContactEntery::query()->orderBy('id', 'desc')->get();
     return view('admin.contactEnteries', [
         'contacts'=>$contacts
     ]);
   }
   //    subscribers
   public function websubscribers(){
     $subscribers= Subscribers::query()->orderBy('id', 'desc')->get();
     return view('admin.subscribers', [
         'subscribers'=>$subscribers
     ]);
   }
}
