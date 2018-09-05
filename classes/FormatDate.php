<?php

namespace classes;

trait FormatDate
{
	public function formatDate($date)
    {
        list($date, $time) = explode(' ', $date);
        list($year, $month, $day) = explode('-', $date);
        $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $dateFr = $day.' '.$months[$month-1].' '.$year;

        return $dateFr;
    }

    public function formatDateAndHour($date)
    {
        list($date, $time) = explode(' ', $date);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $min, $sec) = explode(':', $time);
        $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $dateFr = $day.' '.$months[$month-1].' '.$year.' à '.$hour.':'.$min.':'.$sec;

        return $dateFr;
    }
}