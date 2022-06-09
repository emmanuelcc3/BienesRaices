<fieldset>

<legend>Informacion General</legend>

<label for="titulo">Titulo:</label>
<input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

<label for="precio">Precio:</label>
<input type="decimal" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>" step=".01">

<label for="imagen">Imagen:</label>
<input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
<?php if ($propiedad -> imagen){ ?>
<img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt=""class="imagen-small">
<?php } ?>
<label for="descripcion">Descripción:</label>
<textarea id="descripcion" name="propiedad[descripcion]" ><?php echo  s($propiedad->descripcion);?></textarea>

</fieldset>
<fieldset>

<legend>Informacion de la propiedad</legend>
<label for="habitaciones">Habitaciones:</label>
<input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo  s($propiedad->habitaciones); ?>">

<label for="wc">Baños:</label>
<input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo  s($propiedad->wc); ?>">

<label for="estacionamiento">Estacionamientos:</label>
<input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?php echo  s($propiedad->estacionamiento); ?>">
</fieldset>

<fieldset>
<legend>Informacion General</legend>
<label for="vendedor">vendedor:</label>
<select name="propiedad[vendedorId]" id="vendedor">
   <option selected value="">---Seleccione---</option> 
    <?php foreach ($vendedores as $vendedor) { ?>
     <option
     <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
     value="<?php echo s($vendedor->id); ?>">
     <?php echo s ($vendedor->nombre) . " " . s($vendedor->apellido); ?>
    </option>
        <?php } ?>
</select>

</fieldset>