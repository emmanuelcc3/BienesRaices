
  <main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php 
    if ($mensaje) {?>
        <p class='alerta exito'><?php echo $mensaje; ?></p>;
    <?php } ?>
    <picture>
      <source srcset="build/img/destacada3.webp" type="image/webp">
      <source srcset="build/img/destacada3.jpg" type="image/jpg">
      <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen contacto">
    </picture>

    <h2>LLene el formulario de contacto</h2>

    <form class="formulario" action="/contacto" method="post">
      <fieldset>
        <legend>Informacion Personal</legend>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Nombre" id="nombre" name="contacto[nombre]" required>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje"  name="contacto[mensaje]"></textarea>
      </fieldset>

      <fieldset>
        <legend>Informacion sobre la propiedad</legend>
        <label for="opciones">Vende o Compra</label>
        <select id="opciones"  name="contacto[tipo]" required>
          <option value="" disabled selected>--Seleccione--</option>
          <option value="Compra">Compra</option>
          <option value="Venda">Venda</option>
        </select>
          <label for="presupuesto">Precio o Presupuesto</label>
          <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto"  name="contacto[precio]" required>
      </fieldset>
      <fieldset>
        <legend>Informacion como desea ser contactado</legend>
       <P>Como desea se contactado</p>
        <div class="forma-contacto">
          <label for="contactar-telefono">Teléfono</label>
        <input  type="radio" value="telefono" id="telefono"  name="contacto[contacto]" required>
          <label for="contactar-email">E-mail</label>
        <input  type="radio" value="email" id="email"  name="contacto[contacto]" required>
        </div>

        <div id="contacto"></div>

      </fieldset>
      <input type="submit" value="Enviar" class="boton-verde">
    </form>
  </main>