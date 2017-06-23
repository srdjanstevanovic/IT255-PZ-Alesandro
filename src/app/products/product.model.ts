
export class Product {
    id: number;
    product_id: number;
    name: string;
    description: string;
    code: number;
    quantity: number;
    price: number;
    image: string;
    total: number;
    elements_number: number;
    type_id: number;
    type: string;
    isAdded: boolean;

    constructor(id: number,
                product_id: number,
                name: string,
                description: string,
                code: number,
                quantity: number,
                price: number,
                image: string,
                total: number,
                elements_number: number,
                type_id: number,
                type: string,
                isAdded: boolean) {
    }
}