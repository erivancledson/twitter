<!--tela cadastro -->
<h2>Tela de Cadastro</h2>
<form method="POST">
	Nome:<br/>
	<input type="text" name="nome" /><br/><br/>

	E-mail:<br/>
	<input type="email" name="email" /><br/><br/>

	Senha:<br/>
	<input type="password" name="senha" /><br/><br/>

	<input type="submit" value="Cadastrar" /><br/><br/>

	<?php
        //se faltar 1 ser preenchido vai mostrar o aviso
	if(!empty($aviso)) {
		echo $aviso;
	}
	?>
</form>