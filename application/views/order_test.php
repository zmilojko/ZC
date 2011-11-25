<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
</head>
<body>

<?php echo form_open('orders/get'); ?>
   time_from: <input type="text" name="time_from" style="" value="2011-11-5 14:00:00"/> (we would like the form YYYY-mm-dd hh:mm:ss)<br/>
   status_filter: <input type="text" name="status" style="" value=""/> (for instance: 1)<br/>
   index_list: <input type="text" name="index_list" style="" value=""/> (comma separated values: 1044, 1045, 1046)<br/>
   indexes_only: <input type="text" name="indexes_only" style="" value=""/> (TRUE or FALSE)<br/>
   <input type="submit" name="mysubmit" value="Test what will come back!" />
</form>

</body>