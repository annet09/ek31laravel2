@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <a href="{{ route('blog.admin.posts.create') }}" class="btn btn-primary">Додати</a>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Автор</th>
                                <th>Категорія</th>
                                <th>Заголовок</th>
                                <th>Дата публікації</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($paginator as $post)
                                @php /** @var \App\Models\BlogPost $post */ @endphp
                                <tr @if (!$post->is_published) style="background-color: #ccc;" @endif>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->user->name }}</td>    {{-- виводимо ім'я користувача і назву категорії зі зв'язаних таблиць --}}
                                    <td>{{ $post->category->title }}</td>
                                    <td><a href="{{ route('blog.admin.posts.edit', $post->id) }}">{{ $post->title }}</a></td>
                                    <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.M H:i') : '' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($paginator->total() > $paginator->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $paginator->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@extends('layouts.main')

@section('content')
    @php /** @var \App\Models\BlogPost $item */ @endphp
    <div class="container">
        @include('blog.admin.posts.includes.result_messages')

        @if ($item->exists)
            <form method="POST" action="{{ route('blog.admin.posts.update', $item->id) }}">
                @method('PATCH')
                @else
                    <form method="POST" action="{{ route('blog.admin.posts.store') }}">
                        @endif
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @include('blog.admin.posts.includes.post_edit_main_col')
                            </div>
                            <div class="col-md-3">
                                @include('blog.admin.posts.includes.post_edit_add_col')
                            </div>
                        </div>
                    </form>
                    @if ($item->exists)
                        <br>
                        <form method="POST" action="{{ route('blog.admin.posts.destroy', $item->id) }}">
                            @method('DELETE')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card card-block">
                                        <div class="card-body ml-auto">
                                            <button type="submit" class="btn btn-link">Видалити</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </form>
        @endif
    </div>
@endsection
