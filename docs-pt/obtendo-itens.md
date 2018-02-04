#Obtendo Items

Existem quatro maneiras para se obter os items de sua tabela:

###getItems()
    public function getItems() : array
    {
        $items = array();
        $sql = "SELECT * FROM $this->tableInUse";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $items = $sql->fetchAll();
        }

        return $items;
    }


###getItem()
###getItemsLike()
###query()