<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DH</title>
    <link rel="stylesheet" href="{{ asset('/css/stylesheet.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/b.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/plugins.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<style>
</style>
<body id="page-top">
    <div id="content">
        <component v-bind:is="$route.meta.layout ? $route.meta.layout : 'DashboardLayout'"></component>
        <vue-progress-bar></vue-progress-bar>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
