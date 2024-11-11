@component('mail::message')
    <h1 style="text-align: center; color: #023e8a;">Line Call Notification</h1>
    <p style="font-size: 18px; color: black; font-weight: 500; text-align: center;">กรุณากดปุ่มด้านล่างนี้ เพื่อไปยังหน้าอนุมัติข้อมูล
    </p>
    @component('mail::button', ['url' => $linkin])
        ทำรายการ
    @endcomponent
@endcomponent
