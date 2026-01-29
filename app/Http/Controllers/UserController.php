<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrow; // Ya App\Models\Issue (Apke model ka naam check karlein)
use App\Models\Message;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        // 🟢 FIXED: 'whereHas' lagaya hai. 
        // Ye sirf wo requests layega jinki Books Database me Zinda hain.
        // Deleted books wali requests automatic gayab ho jayengi.

        $myRequests = Borrow::where('user_id', auth()->id())
            ->whereHas('book') // 👈 YE LINE SABSE ZAROORI HAI
            ->with('book')
            ->latest()
            ->get();

        return view('user.dashboard', compact('myRequests'));
    }

    // ... Baki functions wese hi rahenge (Receipt, Home, Chat etc.) ...
    public function showReceipt($id)
    {
        $borrow = Borrow::where('id', $id)->where('user_id', auth()->id())->where('status', 'issued')->with('book')->first();
        if (!$borrow) {
            if (request()->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Receipt not found']);
            }
            return redirect()->route('user.dashboard')->with('error', 'Receipt not found');
        }

        if (request()->ajax()) {
            $price = number_format($borrow->book->price, 2);
            $issueDate = $borrow->created_at->format('d-M-Y h:i A');
            $dueDate = \Carbon\Carbon::parse($borrow->due_date)->format('d-M-Y');

            $html = '<div style="font-family: \'Helvetica\', sans-serif; max-width: 350px; margin: auto; background: #fff; padding: 20px; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                <div style="text-align: center; border-bottom: 2px dashed #333; padding-bottom: 15px; margin-bottom: 15px;">
                    <h2 style="margin: 0; color: #015551; text-transform: uppercase; letter-spacing: 1px;">Library Slip</h2>
                    <p style="margin: 5px 0 0; font-size: 12px; color: #555;">Official Issue Receipt</p>
                </div>
                <table style="width: 100%; font-size: 13px; line-height: 1.6; color: #333;">
                    <tr><td style="font-weight: bold; color:#777;">Trans ID:</td><td style="text-align: right; font-family: monospace;">#' . $borrow->id . '</td></tr>
                    <tr><td style="font-weight: bold; color:#777;">Student:</td><td style="text-align: right; text-transform: uppercase;">' . auth()->user()->name . '</td></tr>
                    <tr><td colspan="2" style="border-bottom: 1px solid #eee; padding: 5px 0;"></td></tr>
                    <tr><td style="font-weight: bold; color:#777; padding-top:10px;">Book:</td><td style="text-align: right; padding-top:10px; font-weight:600;">' . $borrow->book->title . '</td></tr>
                    <tr style="background: #f0fdf4;"><td style="font-weight: bold; color:#015551; padding: 5px;">Price:</td><td style="text-align: right; font-weight: bold; color:#015551; padding: 5px;">$' . $price . '</td></tr>
                </table>
                <div style="margin-top: 15px; border: 1px solid #eee; padding: 10px; border-radius: 5px; background: #f9f9f9;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px;"><span style="color: #777;">Issued:</span><strong>' . $issueDate . '</strong></div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #d63384;"><span style="font-weight: bold;">Due:</span><strong>' . $dueDate . '</strong></div>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <div style="height: 30px; background: repeating-linear-gradient(to right, #000 0, #000 2px, #fff 2px, #fff 4px); width: 60%; margin: 0 auto;"></div>
                    <p style="font-size: 10px; margin-top: 5px;">' . $borrow->id . '-Authorized</p>
                </div>
            </div>';

            return response()->json(['status' => 'success', 'html' => $html, 'borrow_id' => $borrow->id, 'amount' => $borrow->book->price]);
        }
        return view('user.receipt', ['borrow' => $borrow]);
    }

    public function home()
    {
        if (Auth::check() && auth()->user()->is_admin) return redirect()->route('admin.welcome');
        return view('user.home');
    }
    public function about()
    {
        return view('user.about');
    }
    public function rules()
    {
        return view('pages.rules');
    } // Rules page added

    public function booksByCategory($c)
    {
        $b = ($c == 'all') ? Book::with('category')->latest()->get() : Book::whereHas('category', fn($q) => $q->where('name', $c))->latest()->get();
        return view('user.books', ['books' => $b, 'title' => $c]);
    }

    // Chat Functions
    public function contact()
    {
        $messages = Message::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        return view('user.contact', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required']);
        Message::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'subject' => 'User Query',
            'message' => $request->message,
            'sender' => 'user'
        ]);
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // AJAX Chat Fetch (Kept as you requested)
public function fetchMyMessages()
{
    $messages = Message::where('user_id', auth()->id())
        ->latest()
        ->get()
        ->map(function($msg) {
            return [
                'subject' => $msg->subject ?? 'No Subject',
                'message' => $msg->message,
                'reply'   => $msg->reply,
                'sender'  => $msg->sender,
                
                // 🟢 ZABARDASTI CONVERSION: Database ka time utha kar Karachi bana do
                'time'    => \Carbon\Carbon::parse($msg->created_at)
                                ->setTimezone('Asia/Karachi')
                                ->format('d M, Y - h:i A'),
                                
                'ago'     => \Carbon\Carbon::parse($msg->created_at)
                                ->setTimezone('Asia/Karachi')
                                ->diffForHumans()
            ];
        });

    return response()->json($messages);
}

    public function sendMessageAjax(Request $request)
    {
        $request->validate(['message' => 'required']);
        Message::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'subject' => $request->subject ?? 'Chat Message',
            'message' => $request->message,
            'sender' => 'user'
        ]);
        return response()->json(['status' => 'success']);
    }
}
