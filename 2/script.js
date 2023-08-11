$(document).ready(() => {
  $("#sortBlocks").click(() => {
    $container = $(".blocks");
    $sortableElements = $(".block[data-attr]");
    $unsortableElement = $(".block:not([data-attr])");

    // запоминаем индекс несортируемого элемента в родительском контейнере (до сортировки)
    const unsortableElementIndex = $container
      .children()
      .index($unsortableElement);

    // сортируем массив элементов с дата-аттрибутом по ширине
    $sortableElements.sort((a, b) => {
      return $(a).outerWidth() < $(b).outerWidth() ? -1 : 1;
    });

    // добавляем отсортированные элементы в контейнер
    $sortableElements.each((index, el) => {
      $container.append($(el));
    });

    // возвращаем несортируемый элемент на свое изначальное место
    $unsortableElement.insertAfter(
      $container.children().eq(unsortableElementIndex)
    );
  });
});
