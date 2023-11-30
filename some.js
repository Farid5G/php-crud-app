<script>
  edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener('click",(e)=>{
      console.log("edit");
    tr = e.target.parentNode.parentNode;
    title = tr.getElementsByTagName('td')[0].innerText;
    description = tr.getElementsByTagName('td')[1].innerText;
    console.log(title,description);
    })

  })
</script>
data-toggle='modal' data-target='#exampleModal'


data-bs-toggle='modal' data-bs-target='#exampleModal' href='javascript:void(0);' onclick='openModalWithUrl('index.php?title=<?php echo urlencode($row['ntitle']); ?>')'>Edit</a>