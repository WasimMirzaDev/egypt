<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\UserReview;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SiteController extends Controller {
    public function getRates(Request $request)
    {


        $send_currency_name = $request->input('send_currency_name');
        $recive_currency_name = $request->input('recive_currency_name');
        $exchangeRates = ExchangeRate::where('gateway_from', $send_currency_name)
            ->where('gateway_to', $recive_currency_name)
            ->latest()
            ->select('rate_to', 'rate_from', 'percent_charge', 'gateway_from_cur_sym', 'gateway_to_cur_sym')
            ->first();
        if ($exchangeRates) {
            return response()->json([
                "success" => true,
                "data" => $exchangeRates
            ]);
        } else {
            return response()->json([
                'success' => false,
                "message" => 'Exchange rate not found'
            ]);
        }
    }
    public function getInputRates(Request $request)
    {

        $you_get = $request->input('you_get');
        $gateway_from = $request->input('send_currency_name');
        $gateway_to = $request->input('recive_currency_name');
        $sendCurrencyId = $request->input('send_currency_id');

        $currency = Currency::find($sendCurrencyId);
        $minimumLimit = $currency->minimum_limit_for_sell;
        $maximumLimit = $currency->maximum_limit_for_sell;


        $exchangeRates = ExchangeRate::where('gateway_from', $gateway_from)
            ->where('gateway_to', $gateway_to)
            ->latest()
            ->select('rate_to', 'rate_from', 'percent_charge')
            ->first();

        if (empty($you_get)) {

            $result = [
                'you_get' => $exchangeRates->rate_to,
                'you_get_input' => 0,
                'percent_charge' => $exchangeRates->percent_charge,
                'you_send' => $exchangeRates->rate_from,
                'gateway_from_cur_sym' => $exchangeRates->gateway_from_cur_sym,
                'gateway_to_cur_sym' => $exchangeRates->gateway_to_cur_sym,
            ];
            return response()->json([
                "success" => true,
                "data" => $result
            ]);
        }

        if ($exchangeRates) {
            $rate_from = $exchangeRates->rate_from;
            $rate_to = $exchangeRates->rate_to;
            $ratio = $rate_to / $rate_from;
            $you_send = ($you_get * $ratio); // Adjusted calculation
            $percent_charge = $you_send * ($exchangeRates->percent_charge / 100);
            $you_send = $you_send - $percent_charge; // Updated calculation

            $result  = [
                'you_get' => $you_get,
                'percent_charge' => $percent_charge,
                'you_send' => $you_send,
            ];

            return response()->json([
                "success" => true,
                "data" => $result
            ]);
        } else {
            return response()->json([
                'success' => false,
                "message" => 'Exchange rate not found'
            ]);
        }
    }

    public function getRatesByYouSend(Request $request)
    {


        $you_send = $request->you_send;
        $sendCurrencyId = $request->input('send_currency_id');
        $sendCurrencyName = $request->input('send_currency_name');
        $youSend = $request->input('you_send');
        $gateway_from = $request->input('send_currency_name');
        $gateway_to = $request->input('recive_currency_name');
        $currency = Currency::find($sendCurrencyId);
        $minimumLimit = $currency->minimum_limit_for_sell;
        $maximumLimit = $currency->maximum_limit_for_sell;
        // Retrieve the currency from the database
        if ($you_send) {
            if ($youSend < $minimumLimit || $youSend > $maximumLimit) {

                return response()->json([
                    'success' => false,
                    'message' => 'Please Select Limit  '  . intval($minimumLimit) . ' - ' . intval($maximumLimit),
                ]);
            }
        }

        $exchangeRates = ExchangeRate::where('gateway_from', $gateway_from)
            ->where('gateway_to', $gateway_to)
            ->latest()
            ->select('rate_to', 'rate_from', 'percent_charge', 'gateway_from_cur_sym', 'gateway_to_cur_sym')
            ->first();

        if (empty($you_send)) {

            $result = [
                'you_get' => $exchangeRates->rate_to,
                'you_get_input' => 0,
                'percent_charge' => $exchangeRates->percent_charge,
                'you_send' => $exchangeRates->rate_from,
                'gateway_from_cur_sym' => $exchangeRates->gateway_from_cur_sym,
                'gateway_to_cur_sym' => $exchangeRates->gateway_to_cur_sym,
            ];
            return response()->json([
                "success" => true,
                "data" => $result
            ]);
        } elseif (!$exchangeRates) {

            return response()->json([
                'success' => false,
                'message' => '',
            ]);
        }
        $rate_from = $exchangeRates->rate_from;
        $rate_to = $exchangeRates->rate_to;
        $ratio = $rate_from / $rate_to; // Fixed ratio calculation
        $you_get = $you_send * $ratio;
        $percent_charge = $you_get * ($exchangeRates->percent_charge / 100);
        $you_get = $you_get - $percent_charge;
        $result = [
            'you_get' => $you_get,
            'you_get_input' => $you_get,

            'percent_charge' => $percent_charge,
            'you_send' => $you_send,
            'gateway_from_cur_sym' => $exchangeRates->gateway_from_cur_sym,
            'gateway_to_cur_sym' => $exchangeRates->gateway_to_cur_sym,
        ];
        return response()->json([
            "success" => true,
            "data" => $result
        ]);
    }

    public function getLimits(Request $request)
    {


        // Retrieve the currency from the AJAX request
        $currency_id = $request->input('currency_id');

        // Retrieve the limits for the given currency
        $sellCurrency = Currency::find($currency_id);
        if ($sellCurrency) {
            $limits = [
                'min' => $sellCurrency->minimum_limit_for_sell,
                'max' => $sellCurrency->maximum_limit_for_sell,
            ];

            // Return the limits data as JSON
            return response()->json([
                "success" => true,
                "data" => $limits
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => '',
            ]);
        }
    }
    public function index() 
    {

     $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }

        $exchangeFormData = session()->get('HOME_EXCHANGE_FORM_DATA');
        session()->forget('HOME_EXCHANGE_FORM_DATA');

        $pageTitle      = 'Home';
        $sections       = Page::where('template_name', $this->activeTemplate)->where('slug', '/')->first();
        $sellCurrencies = Currency::enabled()->availableForSell()->orderBy('name')->get();
        $buyCurrencies  = Currency::enabled()->availableForBuy()->orderBy('name')->get();
//reviews code
        $reviews = UserReview::with('user')
            ->where('approved', 1) // Filter by approved status
            ->get();

        return view($this->activeTemplate . 'home', compact( "reviews",'pageTitle', 'sections', 'sellCurrencies', 'buyCurrencies', 'exchangeFormData'));
    }

    public function pages($slug)
     {
        $page      = Page::where('template_name', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact() 
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function indexReviews() {
        $pageTitle = "Reviews";
        $reviewss = UserReview::with('user')
            ->where('approved', 1) // Filter by approved status
            ->paginate(10);

        return view($this->activeTemplate . 'reviews', compact('pageTitle','reviewss'));
    }
    public function contactSubmit(Request $request) {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id) 
    {
        $policy    = Frontend::where('id', $id)->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null) 
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog() 
    {
        $pageTitle = "Blogs";
        $blogs     = Frontend::where('template_name', gs()->active_template)->where('data_keys', 'blog.element')->latest()->paginate(getPaginate(12));
        $sections  = Page::where('template_name', $this->activeTemplate)->where('slug', 'blog')->first();
        return view($this->activeTemplate . 'blog', compact('blogs', 'pageTitle', 'sections'));
    }

    public function blogDetails($slug, $id) 
    {
        $blog         = Frontend::where('id', $id)->firstOrFail();

        $pageTitle  = "Blog Details";
        $blogs      = Frontend::where('data_keys', 'blog.element')->where('id', '!=', $blog->id)->latest()->where('template_name', gs()->active_template)->take(5)->get();

        //seo content
        $seoContents['title']              = $blog->data_values->title;
        $seoContents['social_title']       = $blog->data_values->title;
        $seoContents['description']        = strLimit(@$blog->data_values->description, 150);
        $seoContents['social_description'] = strLimit(@$blog->data_values->description, 150);
        $seoContents['image']              = getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '820x440');
        $seoContents['image_size']         = '820x440';

        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'blogs', 'seoContents'));
    }


    public function cookieAccept() 
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);

        return response()->json([
            'success' => true,
            'message' => 'Cookie accepted successfully'
        ]);
    }

    public function cookiePolicy()
     {
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
     {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
     {
        $pageTitle = 'Maintenance Mode';
        $general = gs();
        if ($general->maintenance_mode == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('partials.maintenance', compact('pageTitle', 'maintenance'));
    }

    public function trackExchange(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'exchange_id' => 'required|exists:exchanges,exchange_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()->all()
            ]);
        }

        $exchange = Exchange::where('exchange_id', $request->exchange_id)->first();
        $html     = view($this->activeTemplate . 'user.exchange.exchange_tracking', compact('exchange'))->render();

        if ($exchange) {
            return response()->json([
                'success' => true,
                'html'    => $html
            ]);
        }
    }

    public function subscribe(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.unique' => "You have already subscribed"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'   => $validator->errors(),
                'success' => false,
            ]);
        }
        $subscribe        = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();

        return response()->json([
            'message' => "Thank you for subscribing us",
            'success' => true
        ]);
    }

    public function faq()
     {
        $pageTitle = "Frequently Asked Question";
        $faqs      = Frontend::where('template_name', gs()->active_template)->where('data_keys', 'faq.element')->latest()->get();
        $sections  = Page::where('template_name', $this->activeTemplate)->where('slug', 'faq')->first();
        return view($this->activeTemplate . 'faq', compact('faqs', 'pageTitle', 'sections'));
    }
    public function downloadPdf($hash,$id)
    {


        try {
            $userId = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }

        $exchange = Exchange::where('user_id', auth()->id())
        ->orderBy('id', 'DESC')
        ->where('id', $id)
        ->firstOrFail();
        
        $user=User::where('id',$userId)->firstOrFail();
 $pageTitle = "Download Exchange";
        $pdf = PDF::loadView('partials.pdf', compact('pageTitle', 'user', 'exchange'));
        $fileName  = $exchange->exchange_id . '_' . time();
       
        return $pdf->download($fileName . '.pdf');
        
        return route('user.exchange.invoice', ['id' => $exchange->exchange_id, 'type' => 'download']);
    }
}

