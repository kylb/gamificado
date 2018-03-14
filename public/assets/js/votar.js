function fnLike(id) {
    var vLike = document.getElementById("like" + id).innerHTML.trim();
    var vValue = document.getElementById("like" + id).value;
    var vDislike = document.getElementById("dislike" + id).innerHTML.trim();

    if(vDislike === 'Dislike'){
        if(vLike === "Like"){
            document.getElementById("like" + id).innerHTML = 'Liked';
            $.ajax({
                url: "/forum/votar",
                type: "post",
                data: {
                    avaliation: vValue,
                    id_essay: id
                },
                dataType: "html"
            });
        } else{
            document.getElementById("like" + id).innerHTML = 'Like';
            $.ajax({
                url: "/forum/votar",
                type: 'post',
                data: {
                    avaliation: 0,
                    id_essay: id
                }
            });
        }
    }
}

function fnDislike(id) {
    var vDislike = document.getElementById("dislike" + id).innerHTML.trim();
    var vValue = document.getElementById("dislike" + id).value;
    var vLike = document.getElementById("like" + id).innerHTML.trim();
    if(vLike === 'Like'){
        if(vDislike === "Dislike"){
            document.getElementById("dislike" + id).innerHTML = 'Disliked';
            $.ajax({
                url: "/forum/votar",
                type: "post",
                data: {
                    avaliation: vValue,
                    id_essay: id
                },
                dataType: "html"
            });
        } else{
            document.getElementById("dislike" + id).innerHTML = 'Dislike';
            $.ajax({
                url: "/forum/votar",
                type: "post",
                data: {
                    avaliation: 0,
                    id_essay: id
                },
                dataType: "html"
            });
        }
    }
}