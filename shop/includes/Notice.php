<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Official Notice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Flag Icons CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.6.0/css/flag-icon.min.css" rel="stylesheet">
  <style>
    body {
      background: #373b3e;
      font-family: 'Georgia', serif;
      color: #444;
    }
    .certificate {
      background: #ffffff;
      border: 10px solid #dee2e6;
      padding: 40px;
      margin: 50px auto;
      max-width: 850px;
      box-shadow: 0 0 30px rgba(0,0,0,0.05);
      position: relative;
    }
    .certificate::before, .certificate::after {
      content: "";
      position: absolute;
      border: 5px solid #f8f9fa;
      top: 20px;
      bottom: 20px;
      left: 20px;
      right: 20px;
      z-index: 0;
    }
    .certificate-content {
      position: relative;
      z-index: 1;
      text-align: center;
    }
    .certificate h1 {
      font-size: 38px;
      font-weight: bold;
      color: #5a5a5a;
      margin-bottom: 10px;
    }
    .certificate h2 {
      font-size: 24px;
      color: #6c757d;
      margin-bottom: 30px;
    }
    .notice-text {
      font-size: 18px;
      margin-bottom: 25px;
      line-height: 1.7;
    }
    .signature {
      margin-top: 60px;
      text-align: right;
      font-size: 16px;
    }
    .signature p {
      margin: 0;
    }
    .btn-back {
      margin-top: 30px;
      text-align: center;
    }
    .btn-back .bi {
      margin-left: 10px;
    }
    .language-selector {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 2;
    }
    .language-selector select {
      background-color: #f1f1f1;
      border: 1px solid #ddd;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
    }
    .language-selector option {
      padding-left: 30px;
    }
    .flag-icon {
      margin-right: 10px;
    }
  </style>
</head>
<body>

<!-- Language Selector Dropdown with Flags -->
<div class="language-selector">
  <select class="form-select" onchange="changeLanguage(this)">
    <option value="en" data-icon="flag-icon-us"> <span class="flag-icon flag-icon-us"></span> English</option>
    <option value="bn" data-icon="flag-icon-bd"> <span class="flag-icon flag-icon-bd"></span> বাংলা</option>
  </select>
</div>

<div class="certificate">
  <div class="certificate-content">
    <h1 id="title">Official Notice</h1>
    <h2 id="subheading">Issued by Your Organization Name</h2>

    <p class="notice-text" id="notice-text">
      This is to formally notify all stakeholders that the system will undergo scheduled maintenance on
      <strong>10th May 2025</strong> from <strong>10:00 PM to 12:00 AM</strong>. Access to all internal and public services
      will be unavailable during this window.
    </p>

    <p class="notice-text" id="notice-text2">
      We appreciate your understanding and cooperation during this maintenance period. For urgent concerns,
      please contact the IT support desk in advance.
    </p>

    <div class="signature">
      <p><strong id="authorized">Authorized by: IT Administrator</strong></p>
      <p id="date">Date: 04/05/2025</p>
    </div>
    
    <div class="btn-back">
      <a href="index.html" class="btn btn-primary">
        Back to Home Page
        <i class="bi bi-arrow-right-circle"></i> <!-- Bootstrap Icon for arrow -->
      </a>
    </div>
  </div>
</div>

<!-- Script for Language Change -->
<script>
  function changeLanguage(select) {
    var lang = select.value;

    if (lang === 'bn') {
      document.getElementById('title').innerText = 'সরকারি নোটিশ';
      document.getElementById('subheading').innerText = 'আপনার সংস্থা নাম দ্বারা ইস্যু করা হয়েছে';
      document.getElementById('notice-text').innerHTML = 'এটি সকল স্টেকহোল্ডারদের জানানো যাচ্ছে যে, সিস্টেম ১০ই মে ২০২৫ তারিখে <strong>রাত ১০টা থেকে ১২টা</strong> পর্যন্ত পরিকল্পিত রক্ষণাবেক্ষণের জন্য বন্ধ থাকবে। এই সময়কালে সমস্ত অভ্যন্তরীণ এবং পাবলিক সেবাসমূহ অপ্রাপ্য থাকবে।';
      document.getElementById('notice-text2').innerHTML = 'এই রক্ষণাবেক্ষণ সময়কালে আপনার সহযোগিতার জন্য আমরা কৃতজ্ঞ। জরুরি বিষয়ে, অনুগ্রহ করে আইটি সাপোর্ট ডেস্কের সাথে যোগাযোগ করুন।';
      document.getElementById('authorized').innerText = 'অনুমোদিত: আইটি প্রশাসক';
      document.getElementById('date').innerText = 'তারিখ: ০৪/০৫/২০২৫';
    } else {
      document.getElementById('title').innerText = 'Official Notice';
      document.getElementById('subheading').innerText = 'Issued by Your Organization Name';
      document.getElementById('notice-text').innerHTML = 'This is to formally notify all stakeholders that the system will undergo scheduled maintenance on <strong>10th May 2025</strong> from <strong>10:00 PM to 12:00 AM</strong>. Access to all internal and public services will be unavailable during this window.';
      document.getElementById('notice-text2').innerHTML = 'We appreciate your understanding and cooperation during this maintenance period. For urgent concerns, please contact the IT support desk in advance.';
      document.getElementById('authorized').innerText = 'Authorized by: IT Administrator';
      document.getElementById('date').innerText = 'Date: 04/05/2025';
    }
  }
</script>

</body>
</html>
