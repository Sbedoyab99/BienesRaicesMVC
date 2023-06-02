<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo:</label>
    <input  
        type="text" 
        id="titulo" 
        name="propiedad[titulo]" 
        value="<?php echo s($propiedad->titulo); ?>" 
        placeholder="Propiedad">

    <label for="precio">Precio:</label>
    <input 
        type="number" 
        id="precio" 
        name="propiedad[precio]" 
        value="<?php echo s($propiedad->precio); ?>" 
        placeholder="Precio">

    <label for="imagen">Imagen:</label>
    <input 
        type="file" 
        id="imagen" 
        accept="image/jpeg, image/png"
        name="propiedad[imagen]">

    <?php if($propiedad->imagen): ?>
        <img src="../../imagenes/<?php echo $propiedad->imagen?>" class="imagen-small" alt="imagen actual">
    <?php endif; ?>        

    <label for="descripcion">Descripcion:</label>
    <textarea 
        id="descripcion" 
        name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input 
        type="number" 
        id="habitaciones" 
        name="propiedad[habitaciones]" 
        value="<?php echo s($propiedad->habitaciones); ?>" 
        placeholder="Ej: 3" min="1">
    
    <label for="baños">Baños:</label>
    <input 
        type="number" 
        id="baños" 
        name="propiedad[baños]" 
        value="<?php echo s($propiedad->baños); ?>" 
        placeholder="Ej: 3" min="1">
    
    <label for="estacionamiento">Estacionamientos:</label>
    <input 
        type="number" 
        id="estacionamiento" 
        name="propiedad[estacionamiento]" 
        value="<?php echo s($propiedad->estacionamiento); ?>" 
        placeholder="Ej: 3" min="1"> 
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorid]" id="vendedor">
        <option selected value="">--Seleccione--</option>
        <?php foreach($vendedores as $vendedor): ?>
            <option 
                <?php echo $propiedad->vendedorid === $vendedor->id ? 'selected' : '' ?>
                value="<?php echo s($vendedor->id)?>"><?php echo s($vendedor->nombre) ." ". s($vendedor->apellido);?>
            </option>
        <?php endforeach; ?>
    </select>

</fieldset>