<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}

body {
background-color: #F7F8FA !important;
}
</style>
</head>
<body>
<div style=" max-width: 700px; margin: 0 auto; background-color: #F7F8FA; padding: 40px 50px;">
{{ $header ?? '' }}
<div style="filter: 'drop-shadow(0px 2px 8px rgba(0, 0, 0, 0.05)'; border-radius: 16px; background-color: #FFFFFF">
<img src="{{asset('assets/mailPlane.png')}}" alt="plane"
 style=" width: 100%; border-top-left-radius: 16px; border-top-right-radius: 16px;"/>
<div style="padding: 28px">
{{ Illuminate\Mail\Markdown::parse($slot) }}

{{ $subcopy ?? '' }}
</div>
</div>
{{ $footer ?? '' }}
</div>
</body>
</html>
