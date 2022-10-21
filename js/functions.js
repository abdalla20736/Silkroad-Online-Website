
                       
                    function c1(L1,ID){
                        
                        change = document.getElementById(L1);
                        change.style.textDecoration = "underline";
                        change.href = "?page=myguild&id="+ID+"";

                     
                     }
                     function changepsjs(L1,L2){
                        document.getElementById(L1).placeholder =  L2;
                        document.getElementById(L1).style.boxShadow = "0 0 20px 20px #0A0E1E";
                        document.getElementById(L1).style.borderColor = "red";
                     }
                     function confirm_delete() {
                        return confirm('are you sure?');
                      }
                     function kk(){
                        Swal.fire({
                           title: 'Do you want to save the changes?',
                           showDenyButton: true,
                           showCancelButton: true,
                           confirmButtonText: `Save`,
                           }).then((result) => {
                           
                           if (result.isConfirmed) {
                              
                               window.location.href = "?page=removeepin";
                               
                           } else if (result.isDenied) {
       
                           }
                           })
                           
                           
                           
                     }
                     function getPath(buttonpathimg,getpathimg) {
                        var inputName = document.getElementById(buttonpathimg);
                        document.getElementById(getpathimg).innerHTML = inputName.value;
                        
                   }
                     function noimgcheck(checkbox,inputfile){
                        if(document.getElementById(checkbox).checked == true){
                        document.getElementById(inputfile).disabled = true;
                           }else{
                              document.getElementById(inputfile).disabled = false;
                           }
                     }

                     
