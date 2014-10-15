// Dimensions of sunburst.
var width = 700;
var height = 600;
var radius = Math.min(width, height) / 2;

// Breadcrumb dimesions: width, height, spacing, width of tip/tail.
var b = {
  w: 75, h: 30, s: 3, t: 10
};

// Mapping of step names to colors.
var colors = {
  "1222": "#BA1FAC",
"1223": "#7DEF08",
"1224": "#C43A80",
"1225": "#C153F9",
"1226": "#C38347",
"1227": "#BC6F03",
"1228": "#5B2E90",
"1229": "#552C21",
"1230": "#9B34F3",
"1231": "#B2666E",
"1232": "#3470BA",
"1233": "#495008",
"1234": "#869A89",
"1235": "#3C2BFD",
"1236": "#16595E",
"1237": "#95351E",
"1238": "#DBFE26",
"1239": "#EB6A3E",
"1240": "#8BF2FF",
"1241": "#8C78EB",
"1242": "#EE4EA8",
"1243": "#D2AB10",
"1244": "#95D08A",
"1245": "#452C86",
"1246": "#3A5A15",
"1247": "#1F4D18",
"1248": "#C40337",
"1249": "#6562C9",
"1250": "#3748D4",
"1251": "#52E177",
"1252": "#502885",
"1253": "#B0351F",
"1254": "#6AFB39",
"1255": "#C7AA57",
"1256": "#F2FF27",
"1257": "#071163",
"1258": "#5E9E8E",
"1259": "#0F0FA6",
"1260": "#7E281F",
"1261": "#C5E86F",
"1262": "#4B9107",
"1263": "#82A6B9",
"1264": "#B44B02",
"1265": "#C9398B",
"1266": "#25154D",
"1267": "#17B02F",
"1268": "#E84C8B",
"1269": "#321FF7",
"1270": "#01843C",
"1271": "#E90A28",
"1272": "#DD132C",
"1273": "#EC6CA7",
"1274": "#1ED7D3",
"1275": "#308B55",
"1276": "#6F1832",
"1277": "#46203D",
"1278": "#731A13",
"1279": "#620746",
"1280": "#894C0A",
"1286": "#A1C652",
"1287": "#E8782E",
"1288": "#4BEEEE",
"1289": "#7CED72",
"1290": "#D78863",
"1291": "#347B12",
"1292": "#E51D2F",
"1293": "#4DDA98",
"1294": "#2211C1",
"1295": "#A9C3E3",
"1296": "#47E511",
"1297": "#7AAEA0",
"1298": "#D4FCA0",
"1299": "#C398D2",
"1300": "#25B2BA",
"1301": "#27F614",
"1302": "#37A6C5",
"1303": "#CC4B59",
"1304": "#8386B6",
"1305": "#7F819C",
"1306": "#E93A40",
"1307": "#5C861A",
"1308": "#2FFF9B",
"1309": "#2E41A0",
"1310": "#671C5A",
"1311": "#762EA8",
"1312": "#23CF0A",
"1313": "#BC377B",
"1314": "#95B983",
"1315": "#49EAE9",
"1316": "#A4CB83",
"1317": "#1DD416",
"1318": "#E66815",
"1319": "#9CDFD7",
"1320": "#732B81",
"1321": "#8D9142",
"1322": "#89349A",
"1323": "#DD7041",
"1324": "#AE7D9A",
"1325": "#764ECA",
"1326": "#7A3219",
"1327": "#3B1DF7",
"1329": "#E76F08",
"1333": "#3CC44F",
"1334": "#879888",
"1335": "#5A21DB",
"1336": "#B8AC7B",
"1337": "#8E9FD0",
"1338": "#8A4F2A",
"1339": "#3DACB3",
"1340": "#DEBB56",
"1341": "#4881AC",
"1342": "#CF06ED",
"1344": "#9BAC9B",
"1501": "#585B56",
"1502": "#B44E3C",
"1503": "#FAC86A",
"1504": "#1247C7",
"1505": "#AAF59A",
"1506": "#3C160B",
"1507": "#AFCF1E",
"1508": "#37D645",
"1510": "#762F9E",
"1511": "#8852D1",
"1513": "#F50E31",
"valid": "#C48205",
"invalid": "#9ACF4C",
"null": "#5B3216"  
};

// Total size of all segments; we set this later, after loading the data.
var totalSize = 0; 

var vis = d3.select("#chart").append("svg:svg")
    .attr("width", width)
    .attr("height", height)
    .append("svg:g")
    .attr("id", "container")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var partition = d3.layout.partition()
    .size([2 * Math.PI, radius * radius])
    .value(function(d) { return d.size; });

var arc = d3.svg.arc()
    .startAngle(function(d) { return d.x; })
    .endAngle(function(d) { return d.x + d.dx; })
    .innerRadius(function(d) { return Math.sqrt(d.y); })
    .outerRadius(function(d) { return Math.sqrt(d.y + d.dy); });

// Use d3.text and d3.csv.parseRows so that we do not need to have a header
// row, and can receive the csv as an array of arrays.


d3.text("./data/news/summary.csv", function(text) {
  var csv = d3.csv.parseRows(text);
  var json = buildHierarchy(csv);
  createVisualization(json);
});

// Main function to draw and set up the visualization, once we have the data.
function createVisualization(json) {

  // Basic setup of page elements.
  initializeBreadcrumbTrail();
  drawLegend();
  d3.select("#togglelegend").on("click", toggleLegend);

  // Bounding circle underneath the sunburst, to make it easier to detect
  // when the mouse leaves the parent g.
  vis.append("svg:circle")
      .attr("r", radius)
      .style("opacity", 0);

  // For efficiency, filter nodes to keep only those large enough to see.
  var nodes = partition.nodes(json)
      .filter(function(d) {
      return (d.dx > 0.005); // 0.005 radians = 0.29 degrees
      });

  var path = vis.data([json]).selectAll("path")
      .data(nodes)
      .enter().append("svg:path")
      .attr("display", function(d) { return d.depth ? null : "none"; })
      .attr("d", arc)
      .attr("fill-rule", "evenodd")
      .style("fill", function(d) { return colors[d.name]; })
      .style("opacity", 1)
      .on("mouseover", mouseover);

  // Add the mouseleave handler to the bounding circle.
  d3.select("#container").on("mouseleave", mouseleave);

  // Get total size of the tree = value of root node from partition.
  totalSize = path.node().__data__.value;
 };

// Fade all but the current sequence, and show it in the breadcrumb trail.
function mouseover(d) {

  var percentage = (100 * d.value / totalSize).toPrecision(3);
  var percentageString = percentage + "%";
  if (percentage < 0.1) {
    percentageString = "< 0.1%";
  }

  d3.select("#percentage")
      .text(percentageString);

  d3.select("#explanation")
      .style("visibility", "");

  var sequenceArray = getAncestors(d);
  updateBreadcrumbs(sequenceArray, percentageString);

  // Fade all the segments.
  d3.selectAll("path")
      .style("opacity", 0.3);

  // Then highlight only those that are an ancestor of the current segment.
  vis.selectAll("path")
      .filter(function(node) {
                return (sequenceArray.indexOf(node) >= 0);
              })
      .style("opacity", 1);
}

// Restore everything to full opacity when moving off the visualization.
function mouseleave(d) {

  // Hide the breadcrumb trail
  d3.select("#trail")
      .style("visibility", "hidden");

  // Deactivate all segments during transition.
  d3.selectAll("path").on("mouseover", null);

  // Transition each segment to full opacity and then reactivate it.
  d3.selectAll("path")
      .transition()
      .duration(1000)
      .style("opacity", 1)
      .each("end", function() {
              d3.select(this).on("mouseover", mouseover);
            });

  d3.select("#explanation")
      .style("visibility", "hidden");
}

// Given a node in a partition layout, return an array of all of its ancestor
// nodes, highest first, but excluding the root.
function getAncestors(node) {
  var path = [];
  var current = node;
  while (current.parent) {
    path.unshift(current);
    current = current.parent;
  }
  return path;
}

function initializeBreadcrumbTrail() {
  // Add the svg area.
  var trail = d3.select("#sequence").append("svg:svg")
      .attr("width", width)
      .attr("height", 50)
      .attr("id", "trail");
  // Add the label at the end, for the percentage.
  trail.append("svg:text")
    .attr("id", "endlabel")
    .style("fill", "#000");
}

// Generate a string that describes the points of a breadcrumb polygon.
function breadcrumbPoints(d, i) {
  var points = [];
  points.push("0,0");
  points.push(b.w + ",0");
  points.push(b.w + b.t + "," + (b.h / 2));
  points.push(b.w + "," + b.h);
  points.push("0," + b.h);
  if (i > 0) { // Leftmost breadcrumb; don't include 6th vertex.
    points.push(b.t + "," + (b.h / 2));
  }
  return points.join(" ");
}

// Update the breadcrumb trail to show the current sequence and percentage.
function updateBreadcrumbs(nodeArray, percentageString) {

  // Data join; key function combines name and depth (= position in sequence).
  var g = d3.select("#trail")
      .selectAll("g")
      .data(nodeArray, function(d) { return d.name + d.depth; });

  // Add breadcrumb and label for entering nodes.
  var entering = g.enter().append("svg:g");

  entering.append("svg:polygon")
      .attr("points", breadcrumbPoints)
      .style("fill", function(d) { return colors[d.name]; });

  entering.append("svg:text")
      .attr("x", (b.w + b.t) / 2)
      .attr("y", b.h / 2)
      .attr("dy", "0.35em")
      .attr("text-anchor", "middle")
      .text(function(d) { return d.name; });

  // Set position for entering and updating nodes.
  g.attr("transform", function(d, i) {
    return "translate(" + i * (b.w + b.s) + ", 0)";
  });

  // Remove exiting nodes.
  g.exit().remove();

  // Now move and update the percentage at the end.
  d3.select("#trail").select("#endlabel")
      .attr("x", (nodeArray.length + 0.5) * (b.w + b.s))
      .attr("y", b.h / 2)
      .attr("dy", "0.35em")
      .attr("text-anchor", "middle")
      .text(percentageString);

  // Make the breadcrumb trail visible, if it's hidden.
  d3.select("#trail")
      .style("visibility", "");

}

function drawLegend() {

  // Dimensions of legend item: width, height, spacing, radius of rounded rect.
  var li = {
    w: 75, h: 30, s: 3, r: 3
  };

  var legend = d3.select("#legend").append("svg:svg")
      .attr("width", li.w)
      .attr("height", d3.keys(colors).length * (li.h + li.s));

  var g = legend.selectAll("g")
      .data(d3.entries(colors))
      .enter().append("svg:g")
      .attr("transform", function(d, i) {
              return "translate(0," + i * (li.h + li.s) + ")";
           });

  g.append("svg:rect")
      .attr("rx", li.r)
      .attr("ry", li.r)
      .attr("width", li.w)
      .attr("height", li.h)
      .style("fill", function(d) { return d.value; });

  g.append("svg:text")
      .attr("x", li.w / 2)
      .attr("y", li.h / 2)
      .attr("dy", "0.35em")
      .attr("text-anchor", "middle")
      .text(function(d) { return d.key; });
}

function toggleLegend() {
  var legend = d3.select("#legend");
  if (legend.style("visibility") == "hidden") {
    legend.style("visibility", "");
  } else {
    legend.style("visibility", "hidden");
  }
}

// Take a 2-column CSV and transform it into a hierarchical structure suitable
// for a partition layout. The first column is a sequence of step names, from
// root to leaf, separated by hyphens. The second column is a count of how 
// often that sequence occurred.
function buildHierarchy(csv) {
  var root = {"name": "root", "children": []};
  for (var i = 0; i < csv.length; i++) {
    var sequence = csv[i][0];
    var size = +csv[i][1];
    if (isNaN(size)) { // e.g. if this is a header row
      continue;
    }
    var parts = sequence.split("-");
    var currentNode = root;
    for (var j = 0; j < parts.length; j++) {
      var children = currentNode["children"];
      var nodeName = parts[j];
      var childNode;
      if (j + 1 < parts.length) {
   // Not yet at the end of the sequence; move down the tree.
 	var foundChild = false;
 	for (var k = 0; k < children.length; k++) {
 	  if (children[k]["name"] == nodeName) {
 	    childNode = children[k];
 	    foundChild = true;
 	    break;
 	  }
 	}
  // If we don't already have a child node for this branch, create it.
 	if (!foundChild) {
 	  childNode = {"name": nodeName, "children": []};
 	  children.push(childNode);
 	}
 	currentNode = childNode;
      } else {
 	// Reached the end of the sequence; create a leaf node.
 	childNode = {"name": nodeName, "size": size};
 	children.push(childNode);
      }
    }
  }
  return root;
};

