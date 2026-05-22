<?php

// Завдання 1. Знайти факторіали всіх чисел у масиві.
$arr1 = [];
for ($i = 0; $i < 5; $i++) {
    $arr1[] = rand(1, 10);
}

$factorials = [];
foreach ($arr1 as $num) {
    $fact = 1;
    for ($j = 1; $j <= $num; $j++) {
        $fact *= $j;
    }
    $factorials[] = $fact;
}
echo "Завдання 1:\nПочатковий масив: " . implode(", ", $arr1) . "\nФакторіали: " . implode(", ", $factorials) . "\n\n";


// Завдання 2. Знайти суму чисел масиву, кратних 3 і 5.
$arr2 = [];
for ($i = 0; $i < 30; $i++) {
    $arr2[] = rand(1, 100);
}

$sum2 = 0;
foreach ($arr2 as $num) {
    if ($num % 3 == 0 && $num % 5 == 0) {
        $sum2 += $num;
    }
}
echo "Завдання 2:\nСума чисел, кратних 3 і 5: $sum2\n\n";


// Завдання 3. Знайти найбільше значення у масиві.
$inputArray3 = [45, 12, 89, 3, 76, 21];
$max3 = max($inputArray3);
echo "Завдання 3:\nВхідний масив: " . implode(", ", $inputArray3) . "\nНайбільше значення: $max3\n\n";


// Завдання 4. Порахувати кількість простих чисел у масиві.
$arr4 = [];
for ($i = 0; $i < 20; $i++) {
    $arr4[] = rand(10, 100);
}

$primeCount = 0;
foreach ($arr4 as $num) {
    $isPrime = true;
    if ($num < 2) {
        $isPrime = false;
    } else {
        for ($j = 2; $j <= sqrt($num); $j++) {
            if ($num % $j == 0) {
                $isPrime = false;
                break;
            }
        }
    }
    if ($isPrime) $primeCount++;
}
echo "Завдання 4:\nМасив: " . implode(", ", $arr4) . "\nКількість простих чисел: $primeCount\n\n";


// Завдання 5. Заміна парних індексів на 0 в масиві.
$arr5 = [];
for ($i = 0; $i < 20; $i++) {
    $arr5[] = rand(0, 30);
}

foreach ($arr5 as $index => $value) {
    if ($index % 2 == 0) {
        $arr5[$index] = 0;
    }
}
echo "Завдання 5:\nМасив після заміни парних індексів на 0:\n";
print_r($arr5);
echo "\n";


// Завдання 6. Сума елементів кратних 3 у масиві.
$arr6 = [];
for ($i = 0; $i < 12; $i++) {
    $arr6[] = rand(-20, 20);
}

$sum6 = 0;
foreach ($arr6 as $num) {
    if ($num % 3 == 0) {
        $sum6 += $num;
    }
}
echo "Завдання 6:\nМасив: " . implode(", ", $arr6) . "\nСума елементів, кратних 3: $sum6\n\n";


// Завдання 7. Стислий формат ПІБ для ініціалів без по батькові.
$inputString7 = "Шевченко Тарас";
$parts7 = explode(" ", trim($inputString7));

if (count($parts7) >= 2) {
    $lastName = $parts7[0];
    $firstNameInitial = mb_substr($parts7[1], 0, 1, 'UTF-8') . ".";
    $result7 = $lastName . " " . $firstNameInitial;
    echo "Завдання 7:\nВхідний рядок: $inputString7\nРезультат: $result7\n\n";
}


// Завдання 8. Знайти найближчий рік у масиві, який є високосним.
$inputArray8 = [2023, 2025, 2000, 1999, 2024, 2028];
$leapYears = [];

foreach ($inputArray8 as $year) {
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        $leapYears[] = $year;
    }
}

$smallestLeapYear = !empty($leapYears) ? min($leapYears) : null;
echo "Завдання 8:\nВхідний масив років: " . implode(", ", $inputArray8) . "\nНайменший високосний рік: " . ($smallestLeapYear ?? "Не знайдено") . "\n\n";


// Завдання 9. Обмін мінімального та максимального елементів у масиві.
$arr9 = [];
for ($i = 0; $i < 10; $i++) {
    $arr9[] = rand(1, 100);
}
echo "Завдання 9:\nМасив до обміну: " . implode(", ", $arr9) . "\n";

$minKey = array_search(min($arr9), $arr9);
$maxKey = array_search(max($arr9), $arr9);

$temp = $arr9[$minKey];
$arr9[$minKey] = $arr9[$maxKey];
$arr9[$maxKey] = $temp;

echo "Масив після обміну: " . implode(", ", $arr9) . "\n\n";


// Завдання 10. Обчислення суми та квадратів ряду.
$n = 5;
$sumSquares = 0;
$squaresList = [];

for ($i = 1; $i <= $n; $i++) {
    $square = $i * $i;
    $squaresList[] = $square;
    $sumSquares += $square;
}

echo "Завдання 10:\nn = $n\nКвадрати чисел: " . implode(", ", $squaresList) . "\nСума квадратів: $sumSquares\n";

?>
