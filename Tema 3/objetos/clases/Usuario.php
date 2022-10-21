<?php
    class Usuario {
        protected static $numPartidos = 6;
        protected const NIVEL_MIN = 0;
        protected const NIVEL_MAX = 6;

        protected $nombre;
        protected $apellidos;
        protected $deporte;
        protected $nivel;
        protected $partidos;

        public function __construct(string $nombre, string $apellidos, string $deporte) {
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->deporte = $deporte;
            $this->nivel = self::NIVEL_MIN;
            $this->partidos = [];
        }

        public function introducirResultado(string $resultado): void {
            array_push($this->partidos, $resultado);

            switch ($resultado) {
                case "derrota": ?>
                    <p><?= $this->nombre ?> pierde el partido.</p>
                    <?php break;

                case "empate": ?>
                    <p><?= $this->nombre ?> empata el partido.</p>
                    <?php break;
                
                case "victoria": ?>
                    <p><?= $this->nombre ?> gana el partido.</p>
                    <?php break;
            }
            
            $partidosSeguidos = true;
            $ultimosPartidos = 
                array_values( // Reinicia los índices
                    array_slice( // Extrae los últimos 6 partidos
                        $this->partidos,
                        sizeof($this->partidos) - self::$numPartidos
                    )
                );

            for ($i = 0; $partidosSeguidos && $i < sizeof($ultimosPartidos); $i++) {
                if ($ultimosPartidos[$i] != $resultado) {
                    $partidosSeguidos = false;
                }
            }

            if ($partidosSeguidos && sizeof($this->partidos) >= self::$numPartidos) {
                switch ($resultado) {
                    case "derrota":
                        if ($this->nivel > self::NIVEL_MIN) $this->nivel--;
                        break;
                    
                    case "victoria":
                        if ($this->nivel < self::NIVEL_MAX) $this->nivel++;
                        break;
                }
                array_push($this->partidos, "");
                // Evita que después de subir/bajar nivel
                // pueda subir/bajar otro nivel después de
                // ganar/perder otra partida
            }
        }

        public function imprimirInformación() {
            $nDerrotas = in_array("derrota", $this->partidos)
                ? array_count_values($this->partidos)["derrota"]
                : 0;

            $nEmpates = in_array("empate", $this->partidos)
                ? array_count_values($this->partidos)["empate"]
                : 0;

            $nVictorias = in_array("victoria", $this->partidos)
                ? array_count_values($this->partidos)["victoria"]
                : 0;
            
            ?> <ul style="color: blue;">
                <li>Nombre y Apellidos:
                    <?= $this->nombre . " " . $this->apellidos ?>
                     (<?= get_class($this) ?>)
                </li>
                <li>Deporte: <?= $this->deporte ?></li>
                <li>Nivel: <?= $this->nivel ?></li>
                <li>Estadísticas: 
                    <ul>
                        <li>Victorias:
                            <?= $nVictorias ?>
                        </li>
                        <li>Derrotas:
                            <?= $nDerrotas ?>
                        </li>
                        <li>Empates:
                            <?= $nEmpates ?>
                        </li>
                    </ul>
                </li>
            </ul> <?php }
    }
?>