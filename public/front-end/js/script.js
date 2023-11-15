// kategori yang di Home

// init Isotope
var $grid = $(".collection-list").isotope({
    // options
});
// filter items on button click
$(".filter-button-group").on("click", "button", function () {
    var filterValue = $(this).attr("data-filter");
    resetFilterBtns();
    $(this).addClass("active-filter-btn");
    $grid.isotope({ filter: filterValue });
});

var filterBtns = $(".filter-button-group").find("button");
function resetFilterBtns() {
    filterBtns.each(function () {
        $(this).removeClass("active-filter-btn");
    });
}
// Kategori yang di Home End

// Tombol menghilangkan Pesanan
var tombolTutup = document.getElementById("tombolTutup");
var elemenHapus = document.getElementById("elemenHapus");

// Menambahkan event listener untuk klik pada tombol
tombolTutup.addEventListener("click", function () {
    // Menghapus elemen
    elemenHapus.remove();
});

// Menambahkan Mengurangkan Kuantitas
// $(".quantity button").on("click", function () {
//     var button = $(this);
//     var oldValue = button.parent().parent().find("input").val();
//     if (button.hasClass("btn-plus")) {
//         var newVal = parseFloat(oldValue) + 1;
//     } else {
//         if (oldValue > 1) {
//             var newVal = parseFloat(oldValue) - 1;
//         } else {
//             newVal = 1;
//         }
//     }
//     button.parent().parent().find("input").val(newVal);
// });
