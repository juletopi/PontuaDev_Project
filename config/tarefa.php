<?php

return [
    // Max itens/extras
    'max_itens' => env('TAREFA_MAX_ITENS', 10),
    'max_extras' => env('TAREFA_MAX_EXTRAS', 5),
    'check_constraints_enabled' => env('TAREFA_CHECK_CONSTRAINTS_ENABLED', true),

    // Pontuação default (label map)
    'default_pontuacao_options' => [
        0 => 'Zerou',
        2 => 'Saiu algo',
        3 => 'Quase',
        5 => 'Deu bom',
        8 => 'Extra',
    ],
];
