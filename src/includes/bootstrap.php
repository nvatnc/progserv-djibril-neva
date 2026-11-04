<?php

// À mettre en haut de chaque page de public/ :
//     require __DIR__ . '/../includes/bootstrap.php';
// Quand une page écrit « new PlatManager() », PHP charge tout seul classes/PlatManager.php
spl_autoload_register(function ($classe) {
    require __DIR__ . '/../classes/' . $classe . '.php';
});
