<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flagged Comment Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        h1 {
            color: #007bff;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>A Comment Has Been Flagged</h1>
    <p>The following comment has been flagged for review:</p>
    <p><em>"{{ $commentText }}"</em></p>

    <!-- Check if there are any flagged categories and display them -->
    @if(!empty($categories) && is_array($categories))
        <p>The comment has been flagged for the following reasons:</p>
        <ul>
            @foreach($categories as $category => $value)
                <li>{{ ucfirst(str_replace('_', ' ', $category)) }}</li>
            @endforeach
        </ul>
    @else
        <p>The comment has been flagged for review.</p>
    @endif

    <div class="footer">
        This is an automated message from <strong>Uni Talk</strong>. If you have any questions, feel free to contact us.
    </div>
</div>

</body>
</html>
