
<main class="contenedor seccion contenido-centrado">

<h1><?php echo $propiedad->titulo?></h1>

    <image loading="lazy" src="/imagenes/<?php echo $propiedad->imagen?>" alt="anuncio">


<div class="resume-propiedad">
    <p class="precio">$<?php echo $propiedad->precio?></p>
    <ul class="iconos-caracteristicas">
        <li>
            <img class="iconos" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
            <p><?php echo $propiedad->wc?></p>
        </li>
        <li>
            <img class="iconos" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono wc">
            <p><?php echo $propiedad->estacionamiento?></p>
        </li>
        <li>
            <img class="iconos" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono wc">
            <p><?php echo $propiedad->habitaciones?></p>
        </li>
    </ul>
    <p><?php echo $propiedad->descripcion?>
    </p>
   
</div>


</main>