<?php

namespace src;

class Endereco
{
    public string|int $id;

    public function __construct(
        public string|int $id_user,
        public string $rua,
        public int $numero,
        public string $bairro,
        public string $cidade,
        public string $estado
    )
    {}
}
