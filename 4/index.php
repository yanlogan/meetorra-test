<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Задание 4</title>
</head>

<body>
  <?php
  // функция стандартной сортировки пузырьком
  function bubbleSort(&$arr) {
    $size = count($arr);
    for ($i=0; $i<$size; $i++) {
      for ($j=0; $j<$size-1-$i; $j++) {
        if ($arr[$j+1] < $arr[$j]) {
            $temp = $arr[$j+1];
            $arr[$j+1] = $arr[$j];
            $arr[$j] = $temp;
        }
      }
    }
  }

  // генерация 2х массивов с рандомными числами из 5 элементов
  $randomArray1 = array();
  $randomArray2 = array();

  for ($i=0; $i<5; $i++) {
    $randomArray1[] = rand(1, 100);
    $randomArray2[] = rand(1, 100);
  }

  $twoDimArray = array(
    $randomArray1,
    $randomArray2
  );
?>
  <header>
    <h1>Задание 4</h1>
    <h2>Задание: Дан двумерный массив со случайными цифрами. С помощью php необходимо отсортировать по возрастанию
      каждый
      вложенный массив. При этом нельзя использовать стандартные функции сортировки. В итоге должно получится примерно
      так
      - array(array(1, 2, 4), array(2,3,4,5)).</h2>
  </header>
  <main>
    <div>Неотсортированный двумерный массив:
      <?php
      print_r($twoDimArray);
    ?>
    </div>
    <?php
    foreach ($twoDimArray as &$array) {
      bubbleSort($array);
    }
  ?>
    <div>Отсортированный массив:<?php print_r($twoDimArray)?></div>
  </main>
</body>

</html>