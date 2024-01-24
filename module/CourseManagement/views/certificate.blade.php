<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="certificate.css">
    <title>Certificate of Completion</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    text-align: center;
    padding: 20px;
}

.certificate {
    background-color: #fff;
    border: 5px solid orange;
    padding: 20px;
    margin: 0 auto;
    width: 250mm; /* Width of A4 paper in landscape mode */
    height: 155mm; /* Height of A4 paper in landscape mode */
    text-align: center;
}


.logo {
    width: 100px;
    height: 100px;
    margin-bottom: 20px;
}

h1 {
    font-size: 28px;
    margin-bottom: 10px;
}

h2 {
    font-size: 24px;
    color: #333;
}

h3 {
    font-size: 20px;
    color: #444;
}

p {
    font-size: 16px;
    margin: 10px 0;
}

.date {
    font-weight: bold;
}
.instructor-signature {
    margin-top: 80px;
    text-align: right;
}

.signature-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    position: relative;
    text-align: right; /* Align the text to the right */
}

.signature-title::before {
    content: "";
    display: inline-block;
    width: 22%;
    height: 2px;
    background-color: #333; /* Line color */
    position: absolute;
    top: 0; /* Vertically center the line relative to the title */
    right: 0; /* Align the line to the right */
    transform: translateY(-50%); /* Correctly center the line vertically */
}




    </style>
</head>
<body>
    @php
         $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
    @endphp
    <div class="certificate">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($siteInfo->logo))) }}" height="50px" width="80px">
        <h1>Certificate of Completion</h1>
        <p>This is to certify that</p>
        <h2>{{$enrollmentItem->enrollment->student->first_name}}</h2>
        <p>has successfully completed the course on</p>
        <h3>{{$enrollmentItem->course->title}}</h3>
        <p>on this day</p>
        <p class="date">{{ $enrollmentItem->course->lessonTracking->last()->created_at->format('Y-m-d') }}
        </p>
        {{-- <div class="instructor-signature">
            <p class="signature-title">Instructor Signature</p>
        </div> --}}
    </div>
   
</body>
</html>
