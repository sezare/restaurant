
var addItemID = 0;
function addToCart(item){
    addItemID += 1;
    var selectedItem = document.createElement('div');
    selectedItem.classList.add('Cart.html');
    selectedItem.setAttribute('id',addItemID);
    var img = document.createElement('img');
    img.setAttribute('src',item.children[1].currentSrc);
    var cartItems = document.getElementById("title, price,");
    selectedItem.append(img);
    cartItems.append(selectedItem);

}