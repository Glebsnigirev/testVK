<?php

interface TimeToWordConvertingInterface {
    public function convert(int $hours, int $minutes): string;
}

class TimeToWordConverter implements TimeToWordConvertingInterface {

    public function convert(int $hours, int $minutes): string {

        // Определяем массив слов для чисел 1-12
        $number_words = array(
            1 => "один", 2 => "два", 3 => "три", 4 => "четыре",
            5 => "пять", 6 => "шесть", 7 => "семь", 8 => "восемь",
            9 => "девять", 10 => "десять", 11 => "одиннадцать", 12 => "двенадцать"
        );

        // определяем массив слов для кратных 5
        $multiple_words = array(
            5 => "пять", 10 => "десять", 15 => "четверть", 20 => "двадцать",
            25 => "двадцать пять", 30 => "половина"
        );

        // Получит соответствующее часовое слово
        $hour_word = $number_words[$hours];

        // Определяем подходящее минутное слово
        if ($minutes == 0) {
            $minute_word = "часов";
        } elseif ($minutes == 1) {
            $minute_word = "одна минута после";
        } elseif ($minutes == 59) {
            $minute_word = "одна минута до";
            $hours = ($hours + 1) % 24;
            $hour_word = $number_words[$hours];
        } elseif ($minutes == 15) {
            $minute_word = "четверть";
            $hour_word = $number_words[($hours % 12) + 1];
        } elseif ($minutes == 30) {
            $minute_word = "половина";
            $hour_word = $number_words[($hours % 12) + 1];
        } elseif ($minutes == 45) {
            $minute_word = "четверть";
            $hours = ($hours + 1) % 24;
            $hour_word = $number_words[$hours];
        } elseif ($minutes < 30) {
            $minute_word = $number_words[$minutes];
            if ($minutes == 1) {
                $minute_word .= " минута после";
            } else {
                $minute_word .= " минуты после";
            }
        } else {
            $minute_word = $multiple_words[60 - $minutes];
            $hour_word = $number_words[($hours % 12) + 1];
            if ($minute_word != "половина") {
                if ($minute_word == "пять") {
                    $minute_word .= " минут до";
                } else {
                    $minute_word .= " минут до";
                }
                $hours = ($hours + 1) % 24;
                $hour_word = $number_words[$hours];
            }
        }

        // Объединяем слова часов и минуты и вернем результат
        return "$hour_word $minute_word $hour_word";
    }
}

// Пример
$converter = new TimeToWordConverter();
echo $converter->convert(7, 00) . "\n" . '<br>';
echo $converter->convert(7, 01) . "\n" . '<br>';
echo $converter->convert(7, 03) . "\n" . '<br>';
echo $converter->convert(7, 12) . "\n" . '<br>';
echo $converter->convert(7, 15) . "\n" . '<br>';
echo $converter->convert(7, 22) . "\n" . '<br>';
echo $converter->convert(7, 30) . "\n" . '<br>';
echo $converter->convert(7, 35) . "\n" . '<br>';
echo $converter->convert(7, 41) . "\n" . '<br>';
echo $converter->convert(7, 56) . "\n" . '<br>';
echo $converter->convert(7, 59) . "\n" . '<br>';
