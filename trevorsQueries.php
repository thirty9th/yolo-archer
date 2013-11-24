A bunch of queries I want to hold onto.

alter table employee modify column id int(11) auto_increment;
alter table employee modify column id int(11);
alter table employee auto_increment = 5000;
alter table store_order_history drop foreign key employee_store_order_id;
alter table manages drop foreign key managee_employee_id;
alter table manages drop foreign key manager_employee_id;
select * from login;
select * from employee;