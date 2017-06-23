import { AlesandroPage } from './app.po';

describe('alesandro App', () => {
  let page: AlesandroPage;

  beforeEach(() => {
    page = new AlesandroPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
