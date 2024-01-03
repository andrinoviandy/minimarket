let page = getVars("page").replace('#', '');
//When DOM loaded we attach click event to button
// $(document).ready(function() {
//     //after button is clicked we download the data
//         //start ajax request
//         $.ajax({
//             url: "http://localhost/ALKESV2/json/pembelian_alkes.php",
//             success: function(data) {
//               var json = $.parseJSON(data);
//               alert(json.length); 
//             }
//         });
// });
// fetch("")
let jml = 0;
// fetch('http://localhost/ALKES_2/json/' + page + '.php')
fetch('http://173.212.225.28/ALKES_2/json/' + page + '.php')
    .then(response => response.text())
    .then(data => {
        // jml = data.length
        jml = data
        // console.log('Data awal', jml);
    }
    );
setInterval(() => {
    // fetch('http://localhost/ALKES_2/json/' + page + '.php')
    fetch('http://173.212.225.28/ALKES_2/json/' + page + '.php')
        .then(response => response.text())
        .then(data => {
            // let jml2 = data.length
            let jml2 = data
            // console.log('Data', jml2);
            if (jml !== jml2) {
                loadMore(load_flag = 0, key)
                jml = jml2
            }
        }
        );
}, 500);

