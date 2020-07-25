function read(input){
    var arr = []
    if( input.files && input.files[0] ){
        var viewer = document.getElementById('file-viewer')
        document.getElementById('file-viewer').innerHTML = "";
        for(let i = 0; i < input.files.length ; i++){
            arr[i] = new FileReader()
            
            arr[i].onload = async function f(e) {
                // console.log(i)
                // console.log(input.files[i].size)

                var temparr = viewer.getElementsByTagName("td")
                
                for(let j = 0 ; j < temparr.length; j++){
                    if(temparr[j].innerHTML.toLowerCase().includes(input.files[i].name.toLowerCase())){
                        return
                    }
                }

                var tr = document.createElement("tr")

                var th = document.createElement("th")
                th.innerHTML = (i + 1).toString()

                tr.appendChild(th)

                var filename = document.createElement("td")
                var filesize = document.createElement("td")
                var filetype = document.createElement("i")

                switch(input.files[i].name.split('.').pop().toLowerCase()){
                    case "html":
                        filetype.classList.add("fa")
                        filetype.classList.add("fa-file-code-o")
                        break
                    case "txt":
                        filetype.classList.add("fa")
                        filetype.classList.add("fa-file-o")
                        break
                    case "zip":
                        filetype.classList.add("fa")
                        filetype.classList.add("fa-file-zip-o")
                        break
                    case "jpg":
                        filetype.classList.add("fa")
                        filetype.classList.add("fa-file-photo-o")
                        break
                    case "png":
                        filetype.classList.add("fa")
                        filetype.classList.add("fa-file-photo-o")
                        break
                    
                }

                filename.appendChild(filetype)
                filename.innerHTML = filename.innerHTML + input.files[i].name
                filesize.innerHTML = input.files[i].size + " bytes"

                tr.appendChild(filename)
                tr.appendChild(filesize)

                document.getElementById("file-viewer").appendChild(tr)

            }
            
            arr[i].onload().then(() => {
                arr[i].readAsDataURL(input.files[i])
            })
        }
    }
}