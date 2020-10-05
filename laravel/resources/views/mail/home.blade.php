<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
    <body>
        <form action="{{url('send/email')}}" method="post">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
            Email :
            <input type="text" name="email" id="email">
            Subject : 
            <input type="text" name="subject" id="subject">
            Message : 
            <textarea name="messages" id="messages"></textarea>
            <input type="submit"  value="Submit">
        </form>
    </body>
</html>