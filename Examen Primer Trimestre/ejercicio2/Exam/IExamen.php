<?php
    namespace Exam;

    interface IExamen {
        public function intentar(string $nombre);
        public function obtenerNota(): int;
    }
?>