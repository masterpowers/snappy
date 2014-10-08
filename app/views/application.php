<!doctype html>
<html dir="ltr" lang="en" ng-app="SnappyChat">
	<head>
		<title>SnappyChat</title>

		<link rel="stylesheet" type="text/css" media="all" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Roboto">
		<link rel="stylesheet" type="text/css" media="all" href="/assets/css/dist/bundle.css">

		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.10/angular-ui-router.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pusher/2.1.6/pusher.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
		<script type="text/javascript" src="/assets/js/dist/bundle.js"></script>
	</head>
	<body ng-controller="ApplicationController">
		<ui-view class="container clearfix" />
	</body>
</html>