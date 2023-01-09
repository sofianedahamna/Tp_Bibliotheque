<?php

trait reservationemprunt {


/**
         * getRestitutionDate : Fonction de definition de la date de retour
         * @param array $date array[h,i,s,m,d,Y]
         * @param int $periode: periode {jours ou mois}
         * @param string $typePeriode :$typePeriode en mois/months, jours/days
         * @param string $operator : $operator :+(ajouter)/-(retrancher)
         * @param string $format : format de retour de la date
         * @param string $timeZone : definition de la locale
         * @return string : date retournée au format string
         */
        function getRestitutionDate01(array $date, int $periode, string $typePeriode, string $operator,$format1, $timeZone1): string {
            $cmpt = 0;
            date_default_timezone_set($timeZone1);
            $tmsp = mktime($date[$cmpt], $date[++$cmpt], $date[++$cmpt], $date[++$cmpt], $date[++$cmpt], $date[++$cmpt]);
            $strtotime = strtotime("$operator" . strval($periode) . " $typePeriode", $tmsp);
            return date($format1, intval($strtotime));
        }



        $date = [0, 0, 0, 7,13, 2022];

        echo getRestitutionDate($date, 14, "days", "+","d-m-Y", "Europe/Paris");

	/**
	 */
	function __construct() {
	}
}