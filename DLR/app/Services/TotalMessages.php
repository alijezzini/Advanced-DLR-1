<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\TotalMessageRepository;

class TotalMessages
{
    public static function fakeMessages($messages)
    {
        $aux = array();
        foreach ($messages as $message) {
            if ($message->fake == 1) {
                array_push($aux, $message);
            }
        }
        return $aux;
    }


    public static function totalMessages(
        string | null $year,
        string | null $month,
        string | null $day,
    ) {
        if (is_null($year) and is_null($month) and is_null($day)) {
            $messages = TotalMessageRepository::getAllMessages();
        }
        if (!is_null($year) and !is_null($month) and !is_null($day)) {
            $messages = TotalMessageRepository::getYearMonthDay($year, $month, $day);
        } else {
            if (!is_null($year) and !is_null($month)) {
                $messages = TotalMessageRepository::getYearMonth($year, $month);
            } else {
                if (!is_null($year) and is_null($day)) {
                    $messages = TotalMessageRepository::getYear($year);
                }
            }
        }
        $total_messages_number = $messages->count();
        $totalfake = count(self::fakeMessages($messages));
        return  [
            'status' => 404,
            'Number of total messages' => $total_messages_number,
            'Number of fake messages' => $totalfake,
        ];
    }

    public static function totalSenders(
        string | null $sender,
    ) {
        $Senders = TotalMessageRepository::getSender($sender);

        $total_senders_number = $Senders->count();
        $totalfake = count(self::fakeMessages($Senders));
        return  [
            'status' => 404,
            'Number of total senders' => $total_senders_number,
            'Number of fake senders' => $totalfake,
        ];
    }
}
