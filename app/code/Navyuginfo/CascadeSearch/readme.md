# Cascade Search

A plugin that lets you search product based on category and attributes.
It is wrapped in the form of a widget.

## Usage

Insert following tag in required cms block 

{{widget type="Navyuginfo\CascadeSearch\Block\Widget\Search" category_id_1="category/4" category_id_2="category/2643" car_attribute_1="car_tyre_width" car_attribute_2="car_tyre_aspect" car_attribute_3="car_tyre_rim" bike_attribute_1="bike_tyre_width" bike_attribute_2="bike_tyre_aspect" bike_attribute_3="bike_tyre_rim"}}

category_id_1 and category_id_2 are the cars and bike categories.
car_attribute_1, car_attribute_2 and car_attribute_3 are the car tyre attributes which would be car_tyre_width, car_tyre_aspect and car_tyre_rim in our case.
Same goes for bike tyres.

