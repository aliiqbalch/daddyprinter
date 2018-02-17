function modifyPendingOrder(orderId){
    window.location.href = 'index.php?view=modify&orderId=' + orderId;
}
function viewPendingOrderDetail(orderId){
    window.location.href = 'index.php?view=detail&orderId=' + orderId;
}
function deletePendingOrder(orderId){
    if (confirm('Do You Want Delete this Quotation?')) {
        window.location.href = 'processOrder.php?action=delete&orderId=' + orderId;
    }
}
function viewPendingProductDetail(orderDetId,pid){
    window.location.href = 'index.php?view=productDetail&orderDetId=' + orderDetId + '&pid='+pid;
}

function editPendingProductDetail(orderDetId,pid){
    window.location.href = 'index.php?view=modifyDetail&orderDetId=' + orderDetId + '&pid='+pid;
}