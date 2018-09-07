<style>
	* {
		font-family: sans-serif;
	}
</style>
<div style="width: 50%; margin: auto;">
	<div style="background-color: #8C9EFF; padding-top: 5px; padding-left: 5px; padding-bottom: 5px; border-radius: 5px;">
		<table width="100%" cellspacing="0">
			<tr>
				<td width="100px;"><img src="{{ $message->embed(storage_path('animus_symbol.png')) }}" style="height: 50px; margin-right: 10px;"></td>
				<td><h2 style="color: #ffffff;">Animus</h2></td>
			</tr>
		</table>
	</div>
	<div>
		<span style="font-size: 12px; color: #9d9aa0">Enviado el {{date("d-m-Y")}} a las {{date("H:i:s")}}</span>
		<h3 style="font-size: 14px;">Se ha solicitado la recuperaci&oacute;n de contraseña del hogar {{$home->nick}}</h3>
	</div>
	<p style="padding-bottom: 20px; border-bottom: solid 1px #dddddd;">
		Su nueva contraseña es <stong>{{$password}}</stong>
	</p>

	<p style="color: #9d9aa0; font-size: 12px;">
		Este correo fue generado de forma autom&aacute;tica, por favor no responder a esta direcci&oacute;n
	</p>
</div>
