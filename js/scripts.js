//All links to target open in new tab
let postContent = document.querySelectorAll(".post-content");
let links = [];

postContent.forEach((p) => {
  links.push(p.querySelectorAll("a"));
});

links.forEach((list) => {
  list.forEach((link) => {
    link.target = "_blank";
  });
});
