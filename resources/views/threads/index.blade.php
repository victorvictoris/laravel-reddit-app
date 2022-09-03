<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Reddit App') }}</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"></script>

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <!-- Page Heading -->
    <header class="bg-white shadow">

    </header>

    <!--START: Page Content -->
    <main class="mt-3 p-3">
        <table class="table table-striped table-dark table-bordered">
            <thead>
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Title</th>
                <th class="text-center" scope="col">Message</th>
                <th class="text-center" scope="col">Published @</th>
                <th class="text-center" scope="col">Preview</th>
            </tr>
            </thead>
            <tbody>
            @foreach($threads as $thread)
                <tr>
                    <th scope="row">{{$thread->id}}</th>
                    <td class="text-center">{{$thread->title}}</td>
                    <td class="text-center">{{$thread->text}}</td>
                    <td class="text-center">
                        @empty(!$thread->published_at)
                            Published at: {{$thread->published_at}} @ r/{{$thread->subreddit_name}}
                        @endempty
                    </td>
                    <td class="text-center">
                        <a class="text-white" target="_blank" href="{{route('thread.show', ['thread' => $thread])}}">
                            Preview
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </main>
    <!--END: Page Content -->
</div>
</body>
</html>
