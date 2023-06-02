
<main class="contenedor seccion contenido-centrado">
    <h1>Log In</h1>

    <div id="alerta">
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>  
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST" class="formulario" novalidate>
        <fieldset>

            <legend>Información Inicio de Sesión</legend>

            <label for="email">E-mail</label>
            <input required type="email" name="email" placeholder="Tu Email" id="email">

            <label for="password">Password</label>
            <input required type="password" name="password" placeholder="Password" id="password">

        </fieldset>
        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>