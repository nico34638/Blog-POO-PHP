<?php

    namespace App\Table;

    use Core\Table\Table;

    class PostTable extends Table{

        protected $table = 'billet';

        //recupere les derniers articles return array
        public function last(){
            return $this->query("
                SELECT billet.id, billet.titre, billet.contenu , billet.date_creation, categories.titre as categorie
                FROM billet
                LEFT JOIN categories ON category_id = categories.id
                ORDER BY billet.date_creation DESC");
        }

        public function findWithCategory($id){
            return $this->query("
                SELECT billet.id, billet.titre, billet.contenu , billet.date_creation, categories.titre as categorie
                FROM billet
                LEFT JOIN categories ON category_id = categories.id
                WHERE billet.id = ?" , [$id] , true );
        }

        //recupere les derniers articles en function de la categorie return array
        public function lastByCategory($category_id){
          return $this->query("
              SELECT billet.id, billet.titre, billet.contenu , billet.date_creation, categories.titre as categorie
              FROM billet
              LEFT JOIN categories ON category_id = categories.id
              WHERE billet.category_id = ?
              ORDER BY billet.date_creation DESC",
               [$category_id] );
        }

    }
?>
