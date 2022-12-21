const carte = document.getElementById("menu");
const plats = [
    {
        imgSrc: "./assets/img/img-04.jpg",
        title:"farandole de framboises",
        text: "Un goût pour l'acidité de la framboise et la douceur d'un voile sucré ? Il suffit de demander!"
    },
    {
        imgSrc: "./assets/img/img-05.jpg",
        title:"combo vitaminé",
        text: "Besoin d'un coup de boost ? Envie d'un peu de tout ? On vous propose ce combo pour vous aider à vous rafraîchir !"
    }, {
        imgSrc: "./assets/img/img-06.jpg",
        title:"simple et efficace",
        text: "La sobriété sans négliger le bon, le frais et le goût ? Pas de problème, on a tout prévu pour vous !"
    },
    {
        imgSrc: "./assets/img/img-10.jpg",
        title:"une assiette verte",
        text: "Envie de déguster de la verdure ? Et de beaucoup de fraicheur ? C'est ce plat qui vous ira !"
    },
    {
        imgSrc: "./assets/img/img-11.jpg",
        title:"pluie étoilée",
        text: "Un fruit simple relevé des saveurs uniques de cet anis si spécial ... une délicieuse dégustation !"
    },
    {
        imgSrc: "./assets/img/img-12.jpg",
        title:"agrumes pétillants",
        text: "Vous aimez ce qui pétille ? Vitamines, fraîcheur et toute la pétillance du pamplemousse vous feront oublier tous les autres plats !"
    },
    {
        imgSrc: "./assets/img/img-13.jpg",
        title:"un dragon dans l'assiette",
        text: "Si si, c'est possible ! Vous voulez vérifier ? Alors n'hésitez pas vous en verrez de toutes les couleurs !"
    },
    {
        imgSrc: "./assets/img/img-14.jpg",
        title:"la vie en rose",
        text: "Besoin de lunettes pour voir la vie plus belle ? Commencez par déguster ce plat plein de gaîté et tout ira mieux !"
    }
];

let htmlTemplate = "";
for (const plat of plats) {
    htmlTemplate += `<article class="article"><div class="container"><img class="image" src="${plat.imgSrc}" alt="fresh cooked dish"></div><h2>${plat.title}</h2><p>${plat.text}</p></article>`;
}
menu.innerHTML = htmlTemplate;
