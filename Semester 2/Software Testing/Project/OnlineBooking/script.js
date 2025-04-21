document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('.menu-icon').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('active');
  });
});

document.querySelector('body').addEventListener('scroll', (e) => {
  console.log(e.target.scrollTop);
  document.querySelector('.GoTop').innerHTML = e.target.scrollTop
});

window.addEventListener("scroll", () => {
  const scrollTop = window.scrollY;
  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight;
  const GoTop = document.getElementsByClassName('GoTop');

  const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;
  document.getElementById("progress-bar").style.width = scrollPercentage + "%";

  if (scrollTop > 100) {
    GoTop[0].style.display = "block";
  } else {
    GoTop[0].style.display = "none";
  }
});

const GoTop = document.getElementsByClassName('GoTop');
GoTop[0].addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
const progressBar = document.getElementById("progress-bar");

