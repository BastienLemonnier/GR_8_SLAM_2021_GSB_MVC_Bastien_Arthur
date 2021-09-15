<section id="moisCourant">
    <h2 id="MoisFrais">Frais Forfaitaires du mois de : <?php echo $_SESSION['mois']['libelle']; ?></h2>
    <p>
        Nombre d'étapes : <span class='frais'>
            <?php echo $_SESSION['FraisForfait']['ETP']; ?>
        </span>   /   KmParcourus : <span class='frais'>
            <?php echo $_SESSION['FraisForfait']['KM']; ?>
        </span><br/> NuitéesHorsEtapes : <span class='frais'>
            <?php echo $_SESSION['FraisForfait']['NUI']; ?>
        </span>   /   RepasHorsEtapes : <span class='frais'>
            <?php echo $_SESSION['FraisForfait']['REP']; ?>
        </span>
    </p>
</section>

<?php
    if( isset($_SESSION['FraisHF']) && count($_SESSION['FraisHF']) > 0 ) {
        ?>
        <section>
            <h2>Autres frais :</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Libellé</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for( $i = 0; $i < count($_SESSION['FraisHF']); $i ++ ) {
                            echo "<tr>";
                            echo "<td>".$_SESSION['FraisHF'][$i]['date']."</td>";
                            echo "<td>".$_SESSION['FraisHF'][$i]['libelle']."</td>";
                            echo "<td>".$_SESSION['FraisHF'][$i]['montant']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <?php
    }
?>