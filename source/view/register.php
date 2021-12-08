<form action="<?= url('registrar') ?>" method="post">

    <div class="form_group">

        <label for="first_name">Primeiro Nome</label>
        <input type="text" name="first_name">

    </div>

    <div class="form_group">

        <label for="last_name">Último Nome</label>
        <input type="text" name="last_name">

    </div>

    <div class="form_group">

        <label for="email">E-mail</label>
        <input type="text" name="email">

    </div>

    <div class="form_group">

        <label for="password">Senha</label>
        <input type="password" name="password">

    </div>

    <button>Cadastrar</button>

</form>