@extends('layouts.app')

@section('title', '管理者専用ページ')

@section('content')
    <h2 class="text-center mb-4">管理者専用ページ</h2>
    <div class="d-flex justify-content-center">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary mx-2">トップページに戻る</a>
    </div>
    <form class="text-center mt-4" action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger mx-2">ログアウト</button>
    </form>
@endsection
