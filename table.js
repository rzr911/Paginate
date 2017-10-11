let no=10;
let bflag=0;
let arr=[];
let column=[]; 
let thtml="";

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}


function paginate(no,d,pno)
   {
	
        if(no===undefined)
		no=1;

	if(pno===undefined)
		pno=1;

	var res=2;
	if(d===undefined)
	{
		
	}	


	if(bflag==0)
		{
		var hea=[];

		for(var i=0,row;row=d.rows[i];i++)
			{
			 var v2={};
	 		  for (var j = 0, col; col = row.cells[j]; j++)
			  {
	
			  
				 if(i==0)
				 {
					 hea.push(col.innerHTML);
				 }
				 
				 else
				 {
					 v2[hea[j]]=col.innerHTML;
				 }
				
			   }
		
			if(!isEmpty(v2))
			 arr.push(v2);
	 		}
 
		}
  
	var f=0;

	thtml="<table>";

    	var val = arr[0];
	thtml+="<tr>";
   	for(var j in val)
		{
        	var sub_key = j;
        	var sub_val = val[j];
		
		if(f==0)
		{
			thtml+="<th>"+sub_key+"</th>";
		}
		
   
    
	
		}
	
	recordvar=pno*no-no;
	recordlimit=recordvar+no;
	thtml+="</tr>";
	f=1;recordflag=1;
	   
	for(var i=recordvar;i<recordlimit;i++)
	{
		
		if(i<arr.length)
		{
			
   			 var key = i;thtml+="<tr>";
    			 var val = arr[i];
    			 for(var j in val)
			 {
        			var sub_key = j;
        			var sub_val = val[j];
       				thtml+="<td >"+sub_val+"</td>";
   			 }
			 thtml+="</tr>";
	
			 recordflag++;
		}
		
	}



	if(arr.length%no==0)
		var nobtn=arr.length/no;

	else
		var nobtn=parseInt(arr.length/no) +1;


	thtml+="</table>";
	d.innerHTML=thtml;

	if( arr.length!=no) || no==1)
	{
		if(bflag!=0)
		{
			document.getElementsByClassName("tblebtngroup").remove();
		}
		
		var tbhtml="";
		var el=document.createElement("div");
		el.className="tblebtngroup";
		tbhtml+="<br/>";
		for(var i=1;i<=nobtn;i++)
			{
	
		
			if(nobtn>4)
			{
				if(i==1)
				{ tbhtml+="<button class='tbtn' id='"+i+"'>"+i+"</button>";
			
				}
				else if(i==nobtn)
				{tbhtml+="<button class='tbtn' id='"+i+"'>"+i+"</button>";
			
				}
				else
				{
				
					if(i+1==pno||i-1==pno||i==pno||i+5==pno||i+10==pno||i-5==pno||i-10==pno)
					{
					
					tbhtml+="<button class='tbtn' id='"+i+"'>"+i+"</button>";
					}
					else
					{
					
					tbhtml+="<span></span>";
			
					}
				}
				
			
			
			}
			else
				tbhtml+="<button class='tbtn' id='"+i+"'>"+i+"</button>";
	
		}
	el.setAttribute("style", "width:150px ; margin: 0 auto;");
	el.innerHTML=tbhtml;

	insertAfter(el,d);
	}



	bflag++;



// BUTTON CLICK HERE ///  

	var classname = document.getElementsByClassName("tbtn");

	for (var i = 0; i < classname.length; i++) 
	{
	
   		 classname[i].addEventListener('click', function(){
		 paginate(no,d,this.id)
		
		}, false);
	}



	}
	Element.prototype.remove = function() {
        this.parentElement.removeChild(this);
	}
	
	NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
        for(var i = this.length - 1; i >= 0; i--) 
	{
        	if(this[i] && this[i].parentElement) 
		{
            	this[i].parentElement.removeChild(this[i]);
       		 }
   	 }
}
function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}
