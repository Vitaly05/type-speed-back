@extends( 'emails.layouts.default-layout' )

@section( 'content' )
	<div class="header">
		Сброс пароля на TypeSpeed
	</div>

	<div class="content">
		<p>Мы получили запрос на сброс пароля к вашему аккаунту. Если вы не отправляли запрос, проигнорируйте это
			сообщение.</p>

		<p>Вот ваш код для сброса пароля:</p>

		<p class="code">
			{{ $code }}
		</p>
	</div>
@endsection
