<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input  
        type="text" 
        id="nombre" 
        name="vendedor[nombre]" 
        value="<?php echo s($vendedor->nombre); ?>" 
        placeholder="Nombre">

    <label for="apellido">Apellido:</label>
    <input 
        type="text" 
        id="apellido" 
        name="vendedor[apellido]" 
        value="<?php echo s($vendedor->apellido); ?>" 
        placeholder="Apellido">

    <label for="telefono">Telefono:</label>
    <input 
        type="tel" 
        id="telefono" 
        value="<?php echo s($vendedor->telefono); ?>" 
        name="vendedor[telefono]"
        placeholder="Telefono">
</fieldset>