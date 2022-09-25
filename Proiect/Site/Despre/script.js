
function ochi() {
    const eye = document.querySelector('.iris');
    window.addEventListener('mousemove', (event) => {
        const x = -(window.innerWidth / 2 - event.pageX) / 35;
        const y = -(window.innerHeight / 2 - event.pageY) / 35;
        eye.style.transform = `rotate(-45deg) translateY(${y}px) translateX(${x}px)`;
    });
}

ochi();

$("#minitext").mouseover(function () {
    
    $(".hover").fadeIn('slow',function(){
        $(this).animate({'left': '+=670px'},'slow');
      });

});

$(".hover").mouseleave(function () {
    
    $(".hover").fadeIn('slow',function(){
        $(this).animate({'left': '-=670px'},'slow');
      });

});


function slide(){
    let slideValue = document.getElementById("slider").value;

    document.getElementById("my-img").style.clipPath = "polygon(0 0," + slideValue + "% 0," + slideValue + "% 100%, 0 100%)";

    console.log("polygon(0 0," + slideValue + "% 0," + slideValue + "% 100%, 0 100%)");
}