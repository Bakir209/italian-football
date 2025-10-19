var app =$.spapp({
defaultView:"#page1",
templateDir:"./views/"
})

const navLinks = {
  home: [
    document.getElementById("home"),
  ],
  stats: [
    document.getElementById("Stats"),
  ],
  favs: [
    document.getElementById("favs"),
  ],
  reg: [
    document.getElementById("reg"),
  ],

};

function updateActiveLink(sectionId) {
  Object.keys(navLinks).forEach((key) => {
    navLinks[key].forEach((link) => {
      if (key === sectionId) {
        link.classList.add("current");
      } else {
        link.classList.remove("current");
      }
    });
  });
}


app.route({
view: "page1",
load:"page1.html",
onCreate: function() { console.log("Home page created!"); },
onReady: function() { console.log("Home page ready!"); 
  updateActiveLink("home")

}
});
app.route({
view: "page2",
load:"page2.html",
onCreate: function() { console.log("Stats page created!"); },
onReady: function() { console.log("AStats page ready!");
      updateActiveLink("stats")

 }
});
app.route({
view: "page3",
load:"page3.html",
onCreate: function() { console.log("Favs page created!"); },
onReady: function() { console.log("Favs page ready!");  
   updateActiveLink("favs")

 }
});
app.route({
view: "page4",
load:"page4.html",

onCreate: function() { console.log("Register page created!"); },
onReady: function() { console.log("Register page ready!");  
   updateActiveLink("reg")

 }
});

app.run();

