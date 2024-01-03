// var search = document.getElementById("keyword")
var isi_page = document.getElementById("isi_page")
pagee = '';
// var load_flag = 0
// var key = '';

// loadMore(load_flag, key)
function loading() {
    const xhr = new XMLHttpRequest()
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            isi_page.innerHTML = xhr.responseText
        }
    }
    xhr.open('GET', "include/getLoading.php", true);
    xhr.send()
}

function pilihMenu(page) {
    // loading()
    // setTimeout(() => {
        const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                isi_page.innerHTML = xhr.responseText
            }
        }
        xhr.open('GET', "pages/" + page + ".php?page=" + page, true)
        xhr.send()
        // window.location.href = "page=" + page;
        window.history.pushState(page, '', '?page=' + page.replace('#', ''));

        // load_flag = load_flag + 20
        console.log('page...', page);
        pagee = page
    // }, 500);

}

