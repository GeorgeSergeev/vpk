function showpic(id,all)
{
for (i=0;i<all; i++)
 {
   s=document.getElementById('ibp'+i);
   if (s)
   {
     if (i==id) s.style.display='block';
     else s.style.display='none';
   }
 }
}