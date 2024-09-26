<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('layouts.pages.contact');
    }

    // تخزين رسالة الاتصال
    public function store(ContactRequest $request)
    {
        // لا حاجة لتكرار التحقق من الصحة هنا
        // لأنه يتم التحقق من الصحة في ContactFormRequest

        Contact::create($request->validated());

        // إرسال إشعار عبر البريد الإلكتروني (إذا لزم الأمر)
        // Mail::to('admin@example.com')->send(new ContactMessage($request->all()));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }


}
